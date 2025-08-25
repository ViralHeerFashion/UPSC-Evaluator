<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Beautifying Template</title>
    <style>
        /* Base styling */
        body {
            font-family: verdana;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            /* background-color: #f9f9f9; */
        }
        
        /* Container for content */
        .container {
            width: 100%;
            margin: 0 auto;
            /* padding: 10px; */
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Header section */
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #3498db;
            /* padding-bottom: 20px; */
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
        }
        
        .header p {
            color: #7f8c8d;
            margin: 5px 0 0;
        }
        
        /* Section styling */
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            color: #3498db;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        /* Paragraph styling */
        .paragraph {
            margin-bottom: 15px;
            text-align: justify;
        }
        
        /* Title + description combination */
        .title-desc {
            margin-bottom: 20px;
        }
        
        .title-desc h3 {
            color: #2c3e50;
            margin: 0 0 5px;
            font-size: 18px;
        }
        
        .title-desc p {
            color: #7f8c8d;
            margin: 0;
        }
        
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        
        table th {
            background-color: #3498db;
            color: white;
        }
        
        table tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        
        /* List styling */
        ul, ol {
            margin: 0 0 20px 20px;
            padding: 0;
        }
        
        li {
            margin-bottom: 8px;
        }
        
        ul li {
            list-style-type: disc;
        }
        
        ol li {
            list-style-type: decimal;
        }
        

        .text-bold{font-weight: bold;}
        .table-container {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-row {
            display: table-row;
        }
        
        .table-cell {
            display: table-cell;
            vertical-align: top;
            border: 1px solid #e0e6ed;
        }
        
        .table-cell:first-child {
            border-left: none;
        }
        
        .table-cell:last-child {
            border-right: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <table class="table-container">
                <tr>
                    <td>
                        <div>
                            <h1>GS Evaluation</h1>
                            <p>Generated on: {{ date("M d, Y", strtotime($student_answer_sheet->created_at)) }}</p>
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div>{{ $student_answer_sheet->file_name }}</div>  
                    </td>
                </tr>
            </table>
            
        </div>
        
        @foreach($student_answer_sheet->student_answer_evaluation as $question)
        <p class="text-bold">{{ $question->question_no }}) {{ $question->question }}</p>
        <div class="section">
            <h2 class="section-title">Question Deconstruction</h2>
            <p class="paragraph">{{ $question->deconstruction }}</p>
        </div>

        <div class="section">
            <h2 class="section-title">Micro-Marking Grid</h2>
            <table>
                <thead>
                    <tr>
                        <th>Component</th>
                        <th>Weight</th>
                        <th>Max</th>
                        <th>Given</th>
                        <th>Justification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($question->micro_marking_grid as $grid)
                    <tr>
                        <td>{{ $grid->component }}</td>
                        <td>{{ $grid->weight }}</td>
                        <td>{{ $grid->max_marks }}</td>
                        <td>{{ $grid->marks_awarded }}</td>
                        <td>{{ $grid->justifications }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2 class="section-title">Strengths Snapshot</h2>
            <ul>
            @foreach($question->strength_snapshot as $snapshot)
            <li>{{$snapshot->snapshot}}</li>
            @endforeach
            </ul>
        </div>

        <div class="section">
            <h2 class="section-title">Gap Analysis & Priority Fixes</h2>
            @foreach($question->gap_analysis_priority_fix as $gap)
            <div class="section" style="border: 1px solid black;padding: 0 20px 0 20px;">
                <h3 style="margin: 5px 0 0 0;padding: 0;border-bottom: 1px solid black;">{{ $gap->gap }}</h3>
                <p class="">
                    <h4 style="margin: 5px 0 0 0;padding: 0;">Impact Analysis</h4>
                    {{ $gap->impact }}
                </p>
                <p class="">
                    <h4 style="margin: 5px 0 0 0;padding: 0;">Optimal Solution</h4>
                    {{ $gap->correct_action }}
                </p>
            </div>
            @endforeach
        </div>

        <div class="section">
            <h2 class="section-title">Model Answer</h2>
            <div class="model-answer-container" style="border: 1px solid black;padding: 0 20px 0 20px;">
                @if(!empty($question->model_answer_intro))
                <p>{{ $question->model_answer_intro }}</p>
                @endif
                @foreach($question->model_answer as $model_answer)
                <h3 style="margin: 5px 0 0 0;padding: 0;border-bottom: 1px solid black;">{{ $model_answer->title }}</h3>
                <p>{{$model_answer->description}}</p>
                @endforeach
                @if(!empty($question->model_answer_conclusion))
                <p>{{ $question->model_answer_conclusion }}</p>
                @endif
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Marks Breakdown</h2>
            <div class="model-answer-container" style="border: 1px solid black;padding: 0 20px 0 20px;">
                <h3>{{$question->marks_awarded}} / {{$question->max_marks}} Marks</h3>

            </div>
        </div>
        @endforeach
    </div>
</body>
</html>