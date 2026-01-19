<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
    @font-face {
        font-family: 'muktavaani';
        src: url('{{ $fontPath }}') format('truetype');
    }
    html, body{margin:0;padding:0;width:100%;font-family:'muktavaani', sans-serif;font-size:11pt;line-height:1.65;color:#1f2933;}
    .header{background:#1f2933;}
    .header-table{width:100%;border-collapse:collapse;}
    .header-left{padding:14pt 18pt;}
    .header-label{font-size:9pt;letter-spacing:1px;color:#9fb3c8;font-weight:700;}
    .subject{font-size:18pt;font-weight:700;color:#f1f5f9;}
    .filename{font-size:10pt;color:#cbd5e1;}
    .header-right{width:90pt;text-align:center;}
    .qr-box{background:#ffffff;padding:4pt;}
    .accent{height:3pt;background:#94a3b8;}
    .question{font-size:15pt;font-weight:700;margin:12pt 0 10pt 0;}
    .section-title{font-size:13pt;font-weight:700;margin:12pt 0 4pt 0;}
    .section-line{height:1pt;background:#e5e7eb;margin-bottom:6pt;}
    .text{font-size:10.8pt;color:#2f3438;}
    .table{width:100%;border-collapse:collapse;font-size:10.5pt;}
    .table th{border-bottom:2px solid #1f2933;padding:6pt 4pt;text-align:left;font-weight:700;}
    .table td{border-bottom:1px solid #e5e7eb;padding:6pt 4pt;vertical-align:top;}
    .panel{background:#f8fafc;border:1px solid #e5e7eb;padding:8pt;margin-top:6pt;}
    .marks-wrap{margin-top:16pt;text-align:right;}
    .marks{font-size:22pt;font-weight:800;}
    .marks span{font-size:12pt;color:#64748b;}
    .marks-label{font-size:9pt;color:#64748b;}
    .mb-6{ margin-bottom:6pt; }
    .mb-10{ margin-bottom:10pt; }
</style>
</head>

<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <div class="header-label">GS EVALUATION</div>
                    <div class="subject">General Studies</div>
                    <div class="filename">{{ $student_answer_sheet->file_name }}</div>
                </td>
                <td class="header-right">
                    <div class="qr-box">
                        <img src="{{ asset('public/images/qrcode.png') }}" width="70">
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="accent"></div>

    @php($i = 1)
    @foreach($student_answer_sheet->student_answer_evaluation as $question)
        @if($i > 1)
        <pagebreak />
        @endif

        <div class="question"><b>Q{{ $i }}. {{ $question->question }}</b></div>
        <div class="section-title"><b>Question Deconstruction</b></div>
        <div class="section-line"></div>
        <div class="text mb-10">
            {{ $question->deconstruction }}
        </div>

        <div class="section-title"><b>Micro-Marking Grid</b></div>
        <div class="section-line"></div>

        <table class="table mb-10">
            <thead>
                <tr>
                    <th style="">Component</th>
                    <th style="text-align:center;">Weight</th>
                    <th style="text-align:center;">Max</th>
                    <th style="text-align:center;">Given</th>
                    <th>Justification</th>
                </tr>
            </thead>
            <tbody>
            @foreach($question->micro_marking_grid as $g)
                <tr>
                    <td>{{ $g->component }}</td>
                    <td style="text-align:center;">{{ $g->weight }}%</td>
                    <td style="text-align:center;">{{ $g->max_marks }}</td>
                    <td style="text-align:center;font-weight:700;">{{ $g->marks_awarded }}</td>
                    <td>{{ $g->justifications }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="section-title"><b>Strengths Snapshot</b></div>
        <div class="section-line"></div>
        <table class="table mb-10">
            @foreach($question->strength_snapshot as $k=>$s)
            <tr>
                <td width="24" style="font-weight:700;">{{ $k+1 }}.</td>
                <td>{{ $s->snapshot }}</td>
            </tr>
            @endforeach
        </table>

        
        <div class="section-title"><b>Gap Analysis & Priority Fixes</b></div>
        <div class="section-line"></div>

        @foreach($question->gap_analysis_priority_fix as $index => $gap)

            <div class="panel mb-10">
                <div style="font-weight:700;font-size:11.5pt;margin-bottom:4pt;">
                    <b>{{ $index + 1 }})</b> {{ $gap->gap }}
                </div>
                <div style="font-size:10.5pt;line-height:1.6;margin-bottom:6pt;">
                    <b>Impact Analysis:</b> {{ $gap->impact }}
                </div>
                <div style="font-size:10.5pt;line-height:1.6;">
                    <b>Optimal Solution:</b>
                </div>

                @if(str_contains($gap->correct_action, '$'))
                    <?php
                        /*$pos = mb_strpos($gap->correct_action, '$', 0, 'UTF-8');
                        if ($pos === false) {
                            $pos = mb_strpos($gap->correct_action, '$', 0, 'UTF-8');
                        }

                        $heading = mb_substr($gap->correct_action, 0, $pos, 'UTF-8');
                        preg_match_all('/\(\d+\)\s*([^()]+)/u', $gap->correct_action, $matches);
                        $points = array_map('trim', $matches[1]);*/
                    ?>
                    <?php
                        $text = $gap->correct_action;
                
                        $pos = mb_strpos($text, '$', 0, 'UTF-8');
                
                        $heading = trim(mb_substr($text, 0, $pos, 'UTF-8'));
                
                        preg_match_all('/\$\s*([^$]+)/u', $text, $matches);
                        $points = array_map('trim', $matches[1]);
                    ?>

                    <div style="margin:4pt 0;font-weight:600;">
                        {{ $heading }}
                    </div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        @foreach($points as $pIndex => $point)
                        <tr>
                            <td width="22" valign="top" style="font-weight:700;">
                                {{ $pIndex + 1 }}.
                            </td>
                            <td style="padding-bottom:3pt;">
                                {{ $point }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <div style="margin-top:3pt;">
                        {{ $gap->correct_action }}
                    </div>
                @endif
            </div>
        @endforeach


        <div class="section-title"><b>Model Answer Architectural Points</b></div>
        <div class="section-line"></div>

        @if(!empty($question->custom_model_answer))
            @php($custom_model_answer = json_decode(json_decode($question->custom_model_answer)->model_answer))
            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            @foreach($custom_model_answer as $model_answer)
                @if($model_answer->type == "heading")
                <tr>
                    <td style="font-size:13pt;font-weight:700;color:#1f2933;padding:6pt 0 3pt 0;border-bottom:1px solid #1f2933;">
                        <b>{{ $model_answer->text }}</b>
                    </td>
                </tr>
                @endif

                @if($model_answer->type == "paragraph")
                <tr>
                    <td style="font-size:10.5pt;line-height:1.65;color:#2f3438;padding:4pt 0 6pt 0;">
                        {{ $model_answer->text }}
                    </td>
                </tr>
                @endif

                
                @if($model_answer->type == "list")
                <tr>
                    <td style="padding:2pt 0 6pt 0;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            @foreach($model_answer->items as $index => $item)
                            <tr>
                                <td width="22" valign="top" style="font-size:10.5pt;font-weight:700;color:#1f2933;padding-top:2pt;">{{ $index + 1 }}.
                                </td>
                                <td style="font-size:10.5pt;line-height:1.6;color:#2f3438;padding-bottom:4pt;">
                                    @if(!empty($item->heading))
                                        <span style="font-weight:700;">
                                            <strong>{{ $item->heading }}</strong>
                                        </span>
                                    @endif
                                    @if(!empty($item->text))
                                        <span> {{ $item->text }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                @endif

                @if($model_answer->type == "table")
                <tr>
                    <td style="padding:6pt 0 8pt 0;">
                        @if(!empty($model_answer->caption))
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:4pt;">
                            <tr>
                                <td style="font-size:12pt;font-weight:700;color:black;">
                                    {{ $model_answer->caption }}
                                </td>
                            </tr>
                        </table>
                        @endif

                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:10.5pt;">
                            <thead>
                                <tr>
                                    @foreach($model_answer->headers as $header)
                                    <th style="border:1px solid #d1d5db;background:#1f2933;color:#ffffff;padding:6pt;font-weight:700;text-align:left;">
                                        {{ $header }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($model_answer->rows as $rows)
                                <tr>
                                    @foreach($rows as $row)
                                    <td style="border:1px solid #d1d5db;padding:6pt;line-height:1.5;color:#2f3438;">
                                        {{ $row }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endif
            @endforeach
            </table>
        @else


            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0 0 14pt 0;">
                <tr>
                    <td style="border:1px solid #d1d5db;padding:12pt 14pt;background:#ffffff;">

                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="border-collapse:collapse;margin:0 0 8pt 0;">
                            <tr>
                                <td style="font-size:10.5pt;line-height:1.65;color:#2f3438;padding:5px;font-style: italic;background-color: #efebeb;color: black;">
                                    Model answer architectural points are intentionally detailed and may exceed prescribed word limits. Use them to understand answer structure, depth, and value-addition.
                                </td>
                            </tr>
                        </table>

                        @if(!empty($question->model_answer_intro))
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0 0 8pt 0;">
                            <tr>
                                <td style="font-size:10.5pt;line-height:1.65;color:#2f3438;padding:0;">
                                    {{ $question->model_answer_intro }}
                                </td>
                            </tr>
                        </table>
                        @endif

                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0 8pt;margin:0;">
                            @foreach($question->model_answer as $model_answer)
                            <tr>
                                <td style="padding:0;">

                                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0;">
                                        <tr>
                                            <td style="font-size:11.5pt;color:black;padding:0 0 2pt 0;border-bottom:1px solid #1f2933;font-weight: bold;">
                                                <b style="font-weight: bold;">{{ $model_answer->title }}</b>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="border-collapse:collapse;margin:3pt 0 0 0;">
                                        <tr>
                                            <td style="font-size:10.5pt;line-height:1.65;color:#2f3438;padding:0;">
                                                {{ $model_answer->description }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        @if(!empty($question->model_answer_evaluation))
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="border-collapse:collapse;margin:8pt 0 0 0;">
                            <tr>
                                <td style="font-size:10.5pt;line-height:1.6;color:#2f3438;padding:0;">
                                    {{ $question->model_answer_evaluation }}
                                </td>
                            </tr>
                        </table>
                        @endif

                        @if(!empty($question->model_answer_conclusion))
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="border-collapse:collapse;margin:8pt 0 0 0;">
                            <tr>
                                <td style="font-size:10.5pt;line-height:1.6;color:#1f2933;font-weight:600;padding:0;">
                                    {{ $question->model_answer_conclusion }}
                                </td>
                            </tr>
                        </table>
                        @endif

                    </td>
                </tr>
            </table>
        @endif


    <div class="marks-wrap">
        <div class="marks">
            {{ $question->marks_awarded }}
            <span>/ {{ $question->max_marks }}</span>
        </div>
        <div class="marks-label">Total Marks Awarded</div>
    </div>
@php($i++)
@endforeach

</body>
</html>
