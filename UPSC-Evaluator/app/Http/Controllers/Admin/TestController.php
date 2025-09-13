<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    StudentAnswerSheet,
    StudentAnswerEvaluation,
    QuestionMicroMarkingGrid,
    StrengthSnapShot,
    GapAnalysisPriorityFixes,
    ModelAnswer
};

class TestController extends Controller
{
    public function index(Request $request)
    {
        $method_name = $request->filled('method_name') ? $request->method_name : null;
        if (!is_null($method_name)) {
            $this->$method_name($request);
        }
    }

    private function deleteEvaluation()
    {
        StudentAnswerSheet::truncate();
        StudentAnswerEvaluation::truncate();
        QuestionMicroMarkingGrid::truncate();
        StrengthSnapShot::truncate();
        GapAnalysisPriorityFixes::truncate();
        ModelAnswer::truncate();
    }

    // http://127.0.0.1:8001/admin/test?method_name=testProcessTast

    private function testProcessTast()
    {
        $file_path = "answer_sheets/yHLuZljjZu8wnNJtnd5cxlB72912BzlfXlfe4MBK.pdf";
        $payload = [
            "answer_sheet" => new \CURLFile(
                storage_path('app/' . $file_path), 
                "application/pdf", 
                "Testing_file_for_Superkalam.pdf"
            )
        ];

        $tempPath = tempnam(sys_get_temp_dir(), 'upload_');
        file_put_contents($tempPath, $file_path);

        $payload = [
            'answer_sheet' => new \CURLFile($tempPath, 'application/pdf', 'Testing_file_for_Superkalam.pdf')
        ];


        $ch = curl_init();

        // dd($payload);

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://upsc-ai-evaluator.onrender.com/api/evaluate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
            ],
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        echo "<pre>";
        print_r($response);
        $this->processTask($response->task_id);
    }

    public function processTask($task_id)
    {
        $url = "https://upsc-ai-evaluator.onrender.com/api/results/".urlencode($task_id);
            
        $api_status = "PENDING";

        $ch = curl_init();

        do {
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
                ],
                CURLOPT_TIMEOUT => 30
            ]);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
            $response = json_decode(curl_exec($ch));
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            echo "<pre>";
            print_r($response);
            
            error_log(json_encode($response), 0);

            $api_status = isset($response->status) && !empty($response->status) ? $response->status : null;
            if (is_null($api_status)) {
                dd($response);
            }
            sleep(20);
        } while (!is_null($api_status));
    }

    private function deleteMyPDF()
    {
        $student_answer_sheet = StudentAnswerSheet::find(1);
        Storage::delete($student_answer_sheet->pdf);
        dd("PDF deleted successfully");
    }

    private function modelAnswer()
    {
        $student_answer_sheet = StudentAnswerSheet::where('task_id', '9456ff83-6f7b-4975-b160-6919da494908')->first();
        $student_answer_sheet = json_decode($student_answer_sheet->api_response);

        $model_answer = $student_answer_sheet->result->questions[0]->model_answer;
        $model_answer = <<<EOD
        $model_answer
        EOD;

    
        $model_answer_parts =  $this->parseModelAnswer($model_answer);

        dd($model_answer, $model_answer_parts);

        /**
         * 
         1) generate a php code for extract before \n\n** string as model_answer_intro
         2) then extract all the points between ** and \n\n as points array [key => value] here key is point title and value is point description
         3) then extract after last \n\n as model_answer_conclution
         */


    }

    private function parseModelAnswer($text) 
    {
        $model_answer_parts = [
            'model_answer_intro' => null,
            'points' => [],
            'model_answer_conclution' => null
        ];

        // Extract intro (everything before first **)
        $introEndPos = strpos($text, '**');
        if ($introEndPos !== false) {
            $intro = substr($text, 0, $introEndPos);
            if (!empty(trim($intro))) {
                $model_answer_parts['model_answer_intro'] = trim($intro);
            }
        }

        // Extract all points between ** and \n\n
        $pointsPattern = '/\*\*([^*]+?)\*\*([^*]+?)(?=\n\n\*\*|\n\n$|\n\n[^*]|$)/s';
        preg_match_all($pointsPattern, $text, $pointMatches, PREG_SET_ORDER);
        
        foreach ($pointMatches as $match) {
            $key = trim($match[1]);
            $value = trim($match[2]);
            $model_answer_parts['points'][$key] = $value;
        }

        // Extract conclusion by finding the position after the last **
        $lastDoubleAsteriskPos = strrpos($text, '**');
        if ($lastDoubleAsteriskPos !== false) {
            // Find the position of the next ** after the current one to get the end of the last point
            $nextAsteriskPos = strpos($text, '**', $lastDoubleAsteriskPos + 2);
            
            if ($nextAsteriskPos === false) {
                // This is the last **, so everything after the content of the last point is conclusion
                $conclusionStart = strpos($text, "\n\n", $lastDoubleAsteriskPos);
                if ($conclusionStart !== false) {
                    $conclusion = substr($text, $conclusionStart + 2);
                    if (!empty(trim($conclusion))) {
                        $model_answer_parts['model_answer_conclution'] = trim($conclusion);
                    }
                }
            }
        }


        return $model_answer_parts;
    }
    

    private function manageModelAnswer()
    {
        $response = '{
        "result": {
            "metadata": {
            "evaluation_timestamp": 1757678783.9257276,
            "language": "English",
            "method": "two_phase_extraction",
            "performance": {
                "answer_extraction_time": 3.802762746810913,
                "evaluation_time": 11.764854669570923,
                "ocr_time": 18.53351593017578,
                "question_extraction_time": 2.106718063354492,
                "total_time": 36.6057186126709
            },
            "total_marks": 40,
            "total_questions": 3
            },
            "questions": [
            {
                "band": "Average",
                "final_remarks": "The answer demonstrates a basic understanding of the NPT and Indias position, but lacks depth, organization, and clarity.  Significant improvements are needed in analysis, structure, and language.",
                "gaps": [
                {
                    "corrective_action": "The student should provide a more detailed explanation of the NPTs shortcomings, such as its discriminatory nature, the unequal treatment of nuclear weapon states and non-nuclear weapon states, and the limitations of its verification mechanisms.",
                    "gap": "Lack of in-depth analysis of NPT flaws",
                    "impact": "The analysis lacks depth and fails to fully explain why the NPT is considered flawed despite its widespread acceptance."
                },
                {
                    "corrective_action": "The student should elaborate on Indias specific concerns and how these concerns relate to the flaws of the NPT.",
                    "gap": "Insufficient discussion of Indias specific concerns",
                    "impact": "The answer does not adequately address Indias specific concerns regarding the NPT, such as its discriminatory nature and the fact that it does not address the security concerns of states facing nuclear threats."
                },
                {
                    "corrective_action": "The student should improve the organization and structure of the answer by using clear topic sentences, transitions, and a logical flow of ideas.",
                    "gap": "Poor organization and structure",
                    "impact": "The answer is poorly organized and lacks a clear structure, making it difficult to follow the line of reasoning."
                },
                {
                    "corrective_action": "The student should write a stronger conclusion that summarizes the key arguments and provides a clear and concise summary of Indias position on the NPT.",
                    "gap": "Weak conclusion",
                    "impact": "The conclusion does not summarize the main points of the analysis and fails to provide a clear and concise summary of Indias position on the NPT."
                }
                ],
                "keyword_used": "analyze",
                "marks_awarded": 4.5,
                "max_marks": 10,
                "micro_marking_grid": {
                "components": [
                    {
                    "given_marks": 0.5,
                    "justification": "The introduction is weak and lacks a clear definition of the NPTs flaws.  It does not clearly state the analysis scope.",
                    "max_marks": 1.5,
                    "name": "Introduction & Context",
                    "weight_percentage": 15
                    },
                    {
                    "given_marks": 3.0,
                    "justification": "The answer mentions some relevant points regarding Indias position on the NPT and its flaws, such as Indias non-signature and the continued nuclear proliferation despite the treaty. However, the analysis lacks depth and fails to comprehensively examine the interrelationship between the NPTs flaws and Indias stance.  The answer is disorganized and lacks a balanced perspective.",
                    "max_marks": 6,
                    "name": "Key Answer",
                    "weight_percentage": 60
                    },
                    {
                    "given_marks": 0.5,
                    "justification": "The structure is disorganized, and the language contains grammatical errors and unclear phrasing.  The answer is difficult to follow.",
                    "max_marks": 1,
                    "name": "Structure & Language",
                    "weight_percentage": 10
                    },
                    {
                    "given_marks": 0.5,
                    "justification": "The conclusion is weak and does not summarize the key points of the analysis. It lacks a clear and concise summary of Indias position.",
                    "max_marks": 1.5,
                    "name": "Conclusion",
                    "weight_percentage": 15
                    }
                ],
                "total_marks": 4.5
                },
                "model_answer": {
                "body": {
                    "Discriminatory Structure": "The NPTs architecture is inherently discriminatory, granting NWS a privileged status while demanding NNWS to forgo nuclear weapons. This creates a double standard, undermining the treatys credibility.  For instance, the five recognized NWS possess vast arsenals, while NNWS face restrictions.",
                    "Indias Unique Position": "Indias refusal to sign the NPT stems from its belief in the treatys discriminatory nature.  India argues that its nuclear program is for peaceful purposes and that it should not be penalized for not signing the NPT, especially given the lack of progress on disarmament by NWS.  India advocates for a more equitable and just international nuclear order.",
                    "Non-Compliance and Enforcement": "The NPT lacks robust mechanisms for enforcement and addressing non-compliance by NWS.  The treatys effectiveness is hampered by the lack of accountability for states violating its provisions, leading to a sense of injustice among NNWS.  For example, continued nuclear testing by some NWS raises concerns.",
                    "Nuclear Terrorism and Horizontal Proliferation": "The NPT does not adequately address the threat of nuclear terrorism or the possibility of nuclear weapons falling into the hands of non-state actors.  This is a significant concern for all states, including India, which faces potential threats from terrorist groups.  Strengthening security measures is crucial."
                },
                "conclusion": "The NPT, while aiming for nuclear disarmament, has failed to address its inherent flaws.  Indias position highlights the need for a more equitable and just international security architecture that addresses the concerns of both NWS and NNWS.",
                "introduction": "The Nuclear Non-Proliferation Treaty (NPT), despite its near-universal acceptance, suffers from inherent flaws, particularly concerning its discriminatory nature and the unequal treatment of nuclear weapon states (NWS) and non-nuclear weapon states (NNWS).  Indias position reflects these concerns."
                },
                "question_deconstruction": "The question asks for an analysis of the flaws in the Nuclear Non-Proliferation Treaty (NPT) and how these flaws relate to Indias position on the treaty.  The student needs to explain why the NPT is considered flawed despite its widespread acceptance, focusing on the Indian perspective.",
                "question_number": 1,
                "question_text": "Although the treaty on Nuclear Non-Proliferation (NPT) has acquired universal acceptance, it remains deeply flawed. Analyse in the context of Indias position. (10 marks)",
                "strengths": [
                "Mentions Indias non-participation in NPT",
                "Touches upon continued nuclear proliferation as a flaw",
                "Acknowledges Indias nuclear technology needs"
                ],
                "word_limit": 150
            },
            {
                "band": "Off-target",
                "final_remarks": "No answer provided. Student needs to attempt the question with proper structure and content.",
                "gaps": [
                {
                    "corrective_action": "Write a structured answer with introduction, body, and conclusion",
                    "gap": "1. No answer provided",
                    "impact": "Complete lack of response shows no attempt"
                },
                {
                    "corrective_action": "Include relevant facts, examples, and case studies",
                    "gap": "2. No content or examples",
                    "impact": "No demonstration of knowledge or understanding"
                },
                {
                    "corrective_action": "Provide balanced analysis with multiple perspectives",
                    "gap": "3. No analysis or critical thinking",
                    "impact": "No evaluation or discussion of the topic"
                }
                ],
                "marks_awarded": 0,
                "max_marks": 15,
                "micro_marking_grid": {
                "components": [
                    {
                    "given_marks": 0,
                    "justification": "No introduction provided - blank answer.",
                    "max_marks": 2.25,
                    "name": "Introduction & Context",
                    "weight_percentage": 15
                    },
                    {
                    "given_marks": 0,
                    "justification": "No content provided - blank answer.",
                    "max_marks": 9.0,
                    "name": "Key Answer",
                    "weight_percentage": 60
                    },
                    {
                    "given_marks": 0,
                    "justification": "No structure provided - blank answer.",
                    "max_marks": 1.5,
                    "name": "Structure & Language",
                    "weight_percentage": 10
                    },
                    {
                    "given_marks": 0,
                    "justification": "No conclusion provided - blank answer.",
                    "max_marks": 2.25,
                    "name": "Conclusion",
                    "weight_percentage": 15
                    }
                ],
                "total_marks": 0
                },
                "model_answer": {
                "conclusion": "To enhance its credibility, India must prioritize capacity building, strengthen multilateral partnerships, and promote economic cooperation within the IOR.  A proactive and inclusive approach that addresses regional concerns and fosters trust among partners is crucial for achieving a stable and secure Indian Ocean.",
                "evaluation": "Indias success in calibrating its IOR strategy depends on effectively addressing both internal capacity constraints and external geopolitical complexities.  A balanced approach that combines military modernization, diplomatic engagement, and economic cooperation is essential for maintaining credibility as a net security provider.",
                "introduction": "Indias rise as a net security provider in the Indian Ocean Region (IOR) hinges on a calibrated strategy that balances its own interests with regional stability.  Maintaining credibility requires addressing various internal and external obstacles. A nuanced approach is crucial to fostering trust and cooperation amongst regional partners, while effectively countering emerging threats.",
                "sections": {
                    "External Challenges": {
                    "Geopolitical Competition": "The IOR is a region of intense geopolitical competition, with major powers vying for influence.  Chinas growing presence, including its Belt and Road Initiative (BRI) and string of pearls strategy, poses a significant challenge to Indias strategic objectives. This necessitates a proactive approach to engage regional partners and build alliances to counterbalance Chinas influence.",
                    "Regional Rivalries": "Existing regional rivalries and tensions among IOR states complicate Indias efforts to build consensus and cooperation.  Addressing these requires deft diplomacy and conflict resolution mechanisms. For example, India needs to navigate its relationship with Pakistan and other regional players to foster a more cooperative security environment."
                    },
                    "Internal Obstacles": {
                    "Capacity Building Challenges": "India faces limitations in its maritime domain awareness capabilities, including surveillance technology, intelligence gathering, and response mechanisms. For instance, gaps in coastal radar coverage and limited deep-sea surveillance capabilities hinder effective monitoring of the vast IOR.  Addressing this requires significant investment in advanced technologies and capacity building.",
                    "Resource Constraints": "Balancing competing national priorities with the demands of a robust IOR strategy presents a significant challenge.  Limited budgetary allocations for naval modernization, coastal security, and diplomatic initiatives can hinder effective implementation. For example, the need to upgrade aging naval assets competes with other pressing national development goals, requiring careful resource allocation."
                    },
                    "Strategic Imperatives": {
                    "Promoting Economic Cooperation": "India can leverage its economic strength to foster greater cooperation in the IOR.  Initiatives such as the Sagarmala project, aimed at developing Indias ports and coastal infrastructure, can benefit regional partners and promote economic integration. This fosters interdependence and reduces the likelihood of conflict.",
                    "Strengthening Multilateralism": "India should actively participate in and strengthen existing multilateral forums, such as the Indian Ocean Rim Association (IORA), to promote dialogue and cooperation on maritime security. This includes sharing information, conducting joint exercises, and coordinating responses to shared threats.  For example, enhancing IORAs capacity for maritime security cooperation is crucial."
                    }
                }
                },
                "question_deconstruction": "Question 7 requires analysis of the given topic with proper structure and examples.",
                "question_number": 7,
                "question_text": "To maintain credibility as a net security provider, India needs to calibrate its Indian Ocean Strategy. What are the obstacles in this context? How can India overcome them? (15 marks)",
                "strengths": [],
                "word_limit": 250
            },
            {
                "band": "Average",
                "final_remarks": "The answer demonstrates a basic understanding of the topic but lacks depth, analysis, and a proper conclusion.  More detailed analysis and concrete examples are needed to improve the response.",
                "gaps": [
                {
                    "corrective_action": "Provide a more detailed analysis, exploring economic cooperation, connectivity projects, and geopolitical considerations.",
                    "gap": "Lack of in-depth analysis of Myanmars role in Neighbourhood First and Act East policies",
                    "impact": "The answer fails to fully explore the strategic implications of the relationship for India."
                },
                {
                    "corrective_action": "Include specific examples of cooperation, conflicts, or initiatives related to Indias policies.",
                    "gap": "Insufficient use of concrete examples",
                    "impact": "The answer lacks specific instances to support its claims, making it less convincing."
                },
                {
                    "corrective_action": "Add a conclusion that summarizes the key arguments and reiterates Myanmars importance in the context of Indias foreign policy.",
                    "gap": "Absence of a comprehensive conclusion",
                    "impact": "The answer lacks a concluding paragraph summarizing the main points and highlighting the overall significance of Myanmar."
                }
                ],
                "keyword_used": "discuss",
                "marks_awarded": 6.5,
                "max_marks": 15,
                "micro_marking_grid": {
                "components": [
                    {
                    "given_marks": 1.5,
                    "justification": "The introduction is present but lacks depth and context-setting. It mentions the border but doesnt elaborate on its strategic importance.",
                    "max_marks": 2.25,
                    "name": "Introduction & Context",
                    "weight_percentage": 15
                    },
                    {
                    "given_marks": 4.0,
                    "justification": "The answer mentions some relevant points like the long border, people-to-people contact, and security challenges. However, it lacks depth in analyzing the implications of these factors for Indias policies.  The discussion is superficial and lacks concrete examples.",
                    "max_marks": 9,
                    "name": "Key Answer",
                    "weight_percentage": 60
                    },
                    {
                    "given_marks": 1.0,
                    "justification": "The structure is somewhat disorganized. The language is understandable but lacks precision and clarity.  Paragraphing could be improved.",
                    "max_marks": 1.5,
                    "name": "Structure & Language",
                    "weight_percentage": 10
                    },
                    {
                    "given_marks": 0.0,
                    "justification": "The answer lacks a proper conclusion summarizing the key points and emphasizing the overall relevance of Myanmar to Indias policies. | Major penalty: missing conclusion.",
                    "max_marks": 2.25,
                    "name": "Conclusion",
                    "weight_percentage": 15
                    }
                ],
                "total_marks": 6.5
                },
                "model_answer": {
                "conclusion": "Indias engagement with Myanmar is crucial for the success of its Neighbourhood First and Act East policies.  A long-term strategy that prioritizes sustainable development, security cooperation, and diplomatic engagement is essential.  India must continue to support Myanmars democratic transition while safeguarding its own strategic interests.",
                "evaluation": "Myanmars importance to Indias foreign policy is undeniable.  However, navigating the complexities of Myanmars internal politics and external relations requires a nuanced and adaptable strategy.  Indias success hinges on its ability to balance its strategic interests with respect for Myanmars sovereignty and regional stability.",
                "introduction": "Myanmar, Indias eastern neighbor, holds significant geopolitical and strategic importance.  Its location at the crossroads of Indias \"Neighbourhood First\" and \"Act East\" policies makes it crucial for Indias regional influence and connectivity ambitions.  Analyzing Myanmars role in these policies reveals its complex interplay with Indias broader foreign policy objectives and the challenges involved.",
                "sections": {
                    "Act East Policy and Connectivity": {
                    "Improving Connectivity and Trade": "Myanmar is a key link in Indias Act East policy, facilitating connectivity with Southeast Asia.  Projects like the Trilateral Highway connecting India, Myanmar, and Thailand enhance regional connectivity and trade. This improved connectivity opens new markets for Indian businesses and strengthens economic ties with ASEAN countries.",
                    "Strategic Partnerships and Regional Influence": "Indias engagement with Myanmar enhances its strategic influence in the Indo-Pacific region.  Cooperation on defense and security matters, including joint military exercises, strengthens bilateral ties and counters Chinas growing influence in the region.  This strategic partnership is vital for maintaining regional balance of power."
                    },
                    "Challenges and Future Prospects": {
                    "Balancing Competing Interests": "India needs to carefully balance its relations with Myanmar while managing its relations with other regional powers, particularly China.  Chinas significant economic and strategic influence in Myanmar requires a delicate balancing act for India to achieve its objectives.  Indias approach needs to be multi-faceted, encompassing diplomacy, economic cooperation, and security partnerships.",
                    "Political Instability and Internal Conflicts": "Myanmars ongoing political instability and internal conflicts pose significant challenges to Indias engagement.  The situation necessitates a cautious and nuanced approach, balancing Indias interests with the need for stability and respect for Myanmars sovereignty.  Indias humanitarian assistance and diplomatic efforts are crucial in navigating this complex situation."
                    },
                    "Myanmars Geostrategic Location and Neighbourhood First": {
                    "Economic Cooperation and Development Assistance": "India has been actively involved in Myanmars economic development through various initiatives like infrastructure projects, capacity building programs, and investments.  This economic engagement strengthens bilateral ties and promotes regional stability.  The Kaladan Multi-Modal Transit Transport Project, for instance, aims to improve connectivity between Indias northeast and Myanmars ports, boosting trade and regional integration.",
                    "Indias Security Concerns and Border Management": "Myanmar shares a long and porous border with Indias northeastern states.  Cross-border insurgency, drug trafficking, and illegal migration pose significant security challenges. Effective border management and cooperation with Myanmar are crucial for Indias internal security. For example, joint operations against insurgent groups have yielded positive results but require sustained effort."
                    }
                }
                },
                "question_deconstruction": "The question asks for a discussion on Myanmars significance in Indias Neighbourhood First and Act East policies.  It requires an examination of the advantages and disadvantages of the India-Myanmar relationship, considering geopolitical, economic, and security aspects.",
                "question_number": 9,
                "question_text": "Myanmar assumes seminal importance in the context of Indias \"Neighbourhood First\" and \"Act East\" policies. Discuss. (15 marks)",
                "strengths": [
                "Mentions the long India-Myanmar border",
                "Acknowledges people-to-people contact",
                "Touches upon security challenges"
                ],
                "word_limit": 150
            }
            ]
        },
        "status": "SUCCESS"
        }';    

        $response = json_decode($response);
        
        foreach ($response->result->questions as $key => $question) {
            echo "<pre>";
            print_r($question->model_answer);
            echo $question->model_answer->introduction;
            if (isset($question->model_answer->sections)) {
                foreach ($question->model_answer->sections as $key => $section) {
                    foreach ($section as $title => $description) {
                        echo $title . " : " . $description . "<br />";
                    }
                }
            } else {
                foreach ($question->model_answer->body as $title => $description) {
                    echo $title . " : " . $description . "<br />";
                }
            }
        }


    }
}
