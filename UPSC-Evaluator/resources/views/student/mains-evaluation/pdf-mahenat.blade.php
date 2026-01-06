<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Beautifying Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{asset('public/css/fontawesome-all.min.css')}}">
    <style>
       
        @font-face {
            font-family: 'muktavaani', sans-serif;
            src: url('{{ $fontPath }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        html, body {margin: 0;padding: 0;width: 100%;font-family: 'muktavaani', sans-serif;line-height: 1.6;color: #333;margin: 0;padding: 0!important;}
        .pdf-header {width: 100%;background-color: #1f2933;}
        .header-table {width: 100%;border-collapse: collapse;}
        .header-left {padding: 16px 20px;vertical-align: middle;}
        .header-label {font-size: 10px;font-weight: bold;letter-spacing: 1px;text-transform: uppercase;color: #9fb3c8;margin-bottom: 6px;}
        .subject {font-size: 22px;font-weight: bold;color: #f1f5f9;}
        .filename {font-size: 12px;color: #cbd5e1;margin-top: 6px;}
        .header-right {width: 100px;padding: 12px 14px;text-align: center;vertical-align: middle;}
        .qr-box {background-color: #ffffff;padding: 4px;}
        .qr-box img {width: 70px;height: 70px;}
        .header-accent {height: 4px;background-color: #94a3b8; /* neutral silver */}
        .question{font-weight: bold;font-family: verdana;margin-top: 10px;}
    </style>
    <style>
        .title{font-size:17pt;font-weight:700;color:#1f2933;letter-spacing:0.2px;line-height:1.25;}
        .keep-together {page-break-inside: avoid;}
        table {page-break-inside: auto;}
        tr {page-break-inside: avoid;page-break-after: auto;}

        .pdf-card {
    border: 2px solid #e6e9ed!important;
    padding: 9px 11px!important;
    margin-bottom: 6px!important;
}

.card-header {
    page-break-inside: avoid!important;
    margin-bottom: 12px!important;
}

.grid-table {
    width: 100%!important;
    border-collapse: collapse!important;
}

.grid-table tr, .card-body {
    page-break-inside: avoid!important;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="pdf-header">
            <table class="header-table">
                <tr>
                    <td class="header-left">
                        <div class="header-label">GS Evaluation</div>
                        <div class="subject">General Studies</div>
                        <div class="filename">{{ $student_answer_sheet->file_name }}</div>
                    </td>

                    <td class="header-right">
                        <div class="qr-box">
                            <img src="{{ asset('public/images/qrcode.png') }}" alt="QR Code" style="width: 70px;display: inline-block;">
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="header-accent"></div>

        <div class="page-content">
        @php($i = 1)
        @foreach($student_answer_sheet->student_answer_evaluation as $question)
            <p class="text-bold question">{{ $i }}) {{ $question->question }}</p>
            <div class="pdf-card">
                <div class="card-header">
                    <!-- <div class="bar"></div> -->
                    <div class="title">Question Deconstruction</div>
                    <div style="width:42px;height:2px;background:#1f2933;margin-top:7px;"></div>
                </div>

                <div class="card-body">
                    <table class="grid-table">
                        <tr>
                            <td style="padding-left:20px; font-size:14.3px; line-height:1.9; color:#2f3438;">
                                {{ $question->deconstruction }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="pdf-card">
                <div class="card-header">
                    <div class="title">Micro-Marking Grid</div>
                    <div style="width:42px;height:2px;background:#1f2933;margin-top:7px;"></div>
                </div>

                <div class="card-body">
                    <table class="grid-table">
                        <tr>
                            <td style="padding-left:20px; font-size:14.3px; line-height:1.9; color:#2f3438;">
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:0px;border-collapse:collapse;font-size:13.8px;color:#2f3438;">
                                    <thead>
                                        <tr>
                                            <th style="padding:7px 16px;text-align:left;font-weight:800;color:#ffffff;background:#1f2933;width:22%;">Component</th>
                                            <th style="padding:7px 6px;text-align:center;font-weight:700;color:#ffffff;background:#1f2933;width:10%;">Weight</th>
                                            <th style="padding:7px 6px;text-align:center;font-weight:700;color:#ffffff;background:#1f2933;width:12%;">Max</th>
                                            <th style="padding:7px 6px;text-align:center;font-weight:800;color:#ffffff;background:#1f2933;width:14%;">Given</th>
                                            <th style="padding:7px 16px;text-align:left;font-weight:700;color:#ffffff;background:#1f2933;">Justification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($question->micro_marking_grid as $grid)
                                        <tr>
                                            <td style="padding:14px 16px;font-weight:700;color:#1f2933;border-bottom:1px solid #eceff2;vertical-align:top;">{{ $grid->component }}</td>
                                            <td style="padding:14px 12px;text-align:center;border-bottom:1px solid #eceff2;">{{ $grid->weight }}%</td>
                                            <td style="padding:14px 12px;text-align:center;border-bottom:1px solid #eceff2;">{{ $grid->max_marks }}</td>
                                            <td style="padding:14px 12px;text-align:center;font-weight:800;color:#1f2933;border-bottom:1px solid #eceff2;">{{ $grid->marks_awarded }}</td>
                                            <td style="padding:14px 16px;line-height:1.4;border-bottom:1px solid #eceff2;">{{ $grid->justifications }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="pdf-card">
                <div class="card-header">
                    <div class="title">Strengths Snapshot</div>
                    <div style="width:42px;height:2px;background:#1f2933;margin-top:7px;"></div>
                </div>

                <div class="card-body">
                    <table class="grid-table">
                        <tr>
                            <td style="padding-left:20px; font-size:14.3px; line-height:1.9; color:#2f3438;">
                                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0 10px;font-size:14.5px;line-height:1.7;color:#1f2933;">
                                    @foreach($question->strength_snapshot as $index => $snapshot)
                                    <tr>
                                        <td style="padding:0;">

                                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background:#f6f8fc;border:1px solid #d1d5db;">
                                                <tr>
                                                    <td width="34" valign="top" style="background:#eef2ff;border-right:1px solid #d1d5db;text-align:center;font-size:13px;font-weight:600;color:#1f2933;padding:6px 0;">{{ $index + 1 }}</td>
                                                    <td style="padding:6px 10px;font-weight:400;">{{ $snapshot->snapshot }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="pdf-card">
                <div class="card-header">
                    <div class="title">Gap Analysis & Priority Fixes</div>
                    <div style="width:42px;height:2px;background:#1f2933;margin-top:7px;"></div>
                </div>
                @foreach($question->gap_analysis_priority_fix as $index => $gap)
                <div class="card-body">
                    <div style="display:flex; gap:5px; font-weight:700; font-size:12pt; margin-bottom:6pt;color: #222;">
                        <div>{{ $index + 1 }}) {{ $gap->gap }}</div>
                    </div>
                    <div style="background:#f5f7fa;padding:4pt;margin-bottom:6pt;border: 1px solid #eceff2;">
                        <div style="font-weight:700;margin-bottom:3pt;font-size: 12pt;">Impact Analysis</div>
                        <div style="font-size: 11pt;line-height: 13pt;">{{ $gap->impact }}</div>
                    </div>

                    <div style="background:#f5f7fa;padding:4pt;margin-bottom:6pt;border: 1px solid #eceff2;">
                        <div style="font-weight:700;margin-bottom:3pt;font-size: 12pt;">Optimal Solution</div>
                        @if(str_contains($gap->correct_action, '(1)') || str_contains($gap->correct_action, '(१)'))
                            <?php
                                $pos = mb_strpos($gap->correct_action, '(1)', 0, 'UTF-8');
                                if ($pos === false) {
                                    $pos = mb_strpos($gap->correct_action, '(१)', 0, 'UTF-8');
                                }
                                $heading = mb_substr($gap->correct_action, 0, $pos, 'UTF-8');
                                preg_match_all('/\(\d+\)\s*([^()]+)/u', $gap->correct_action, $matches);
                                $points = array_map('trim', $matches[1]);
                            ?>
                            <div style="margin-bottom:4pt;font-size: 11pt;line-height: 13pt;">{{ $heading }}</div>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                @foreach($points as $pIndex => $point)
                                <tr>
                                    <td width="26" valign="top" style="font-weight:600;font-size: 11pt;line-height: 13pt;">
                                        {{ $pIndex + 1 }}.
                                    </td>
                                    <td style="font-size: 11pt;line-height: 13pt;">{{ $point }}</td>
                                </tr>
                                @endforeach
                            </table>
                        @else
                            <div style="font-size: 11pt;line-height: 13pt;">{{ $gap->correct_action }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pdf-card">
                <div class="card-header">
                    <div class="title">Model Answer Architectural Points</div>
                    <div style="width:42px;height:2px;background:#1f2933;margin-top:7px;"></div>
                </div>
                <div class="card-body">
                    @if(!empty($question->custom_model_answer))
                    @php($custom_model_answer = json_decode(json_decode($question->custom_model_answer)->model_answer))

                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0;">
                    @foreach($custom_model_answer as $model_answer)

                        @if($model_answer->type == "heading")
                        <tr>
                            <td style="font-size:13pt;font-weight:700;color:#1f2933;padding:6pt 0 2pt 0;border-bottom:1px solid #1f2933;">
                                {{ $model_answer->text }}
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
                        <tr style="page-break-inside: avoid!important;">
                            <td style="padding:2pt 0 6pt 0;">
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="border-collapse:collapse;page-break-inside: avoid!important;">
                                    @foreach($model_answer->items as $index => $item)
                                    <tr style="page-break-inside: avoid!important;">
                                        <td width="18" valign="top" style="font-size:10.5pt;font-weight:700;color:#1f2933;padding-top:2pt;">
                                            {{ $index + 1 }}.
                                        </td>
                                        <td style="font-size:10.5pt;line-height:1.6;color:#2f3438;padding-bottom:4pt;">
                                            @if(!empty($item->heading))
                                                <span style="font-weight:700;color:#1f2933;">
                                                    {{ $item->heading }}
                                                </span>
                                            @endif
                                            @if(!empty($item->text))
                                                <span>
                                                    {{ $item->text }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        @endif
                        @if($model_answer->type == "table")
                        <tr style="page-break-inside: avoid!important;">
                            <td style="padding:6pt 0 8pt 0;">
                                @if(!empty($model_answer->caption))
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:4pt;page-break-inside: avoid!important;">
                                    <tr style="page-break-inside: avoid!important;">
                                        <td style="font-size:10pt;font-weight:700;color:#1f2933;">
                                            {{ $model_answer->caption }}
                                        </td>
                                    </tr>
                                </table>
                                @endif
                                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:10.5pt;">
                                    <thead>
                                        <tr style="page-break-inside: avoid!important;">
                                            @foreach($model_answer->headers as $header)
                                            <th style="border:1px solid #d1d5db;background:#1f2933;color:#ffffff;padding:6pt;font-weight:700;text-align:left;">
                                                {{ $header }}
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($model_answer->rows as $rows)
                                        <tr style="page-break-inside: avoid!important;">
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
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="border-collapse:collapse;margin:0 0 12pt 0;">
                    <tr>
                        <td style="border:1px solid #d1d5db;padding:10pt 12pt;background:#ffffff;">

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 8pt 0;">
                                <tr>
                                    <td style="font-size:13pt;font-weight:700;color:#1f2933;padding:0;">
                                        Model Answer Architectural Points
                                        <div style="width:38px;height:2px;background:#1f2933;margin-top:4pt;"></div>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0 0 6pt 0;">
                                <tr>
                                    <td style="font-size:10.5pt;line-height:1.6;color:#2f3438;padding:0;">
                                        Model answer architectural points are intentionally detailed and may exceed
                                        word limits. Use them to understand structure and enrich your answers.
                                    </td>
                                </tr>
                            </table>

                            @if(!empty($question->model_answer_intro))
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 6pt 0;">
                                <tr>
                                    <td style="font-size:10.5pt;line-height:1.6;color:#2f3438;padding:0;">
                                        {{ $question->model_answer_intro }}
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- MODEL ANSWER POINTS -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:separate;border-spacing:0 6pt;margin:0;">
                                @foreach($question->model_answer as $model_answer)
                                <tr>
                                    <td style="padding:0;">

                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="border-collapse:collapse;margin:0;">
                                            <tr>
                                                <td style="font-size:11.5pt;font-weight:700;color:#1f2933;padding:0 0 2pt 0;border-bottom:1px solid #1f2933;">
                                                    {{ $model_answer->title }}
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="border-collapse:collapse;margin:2pt 0 0 0;">
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
                                style="border-collapse:collapse;margin:6pt 0 0 0;">
                                <tr>
                                    <td style="font-size:10.5pt;line-height:1.6;color:#2f3438;padding:0;">
                                        {{ $question->model_answer_evaluation }}
                                    </td>
                                </tr>
                            </table>
                            @endif

                            @if(!empty($question->model_answer_conclusion))
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:6pt 0 0 0;">
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
                </div>
            </div>     
            
             <div class="pdf-card">
                <div class="card-header">
                    <div class="title">Marks Breakdown</div>
                    <div style="width:42px;height:2px;background:#1f2933;margin-top:7px;"></div>
                </div>
                <div class="card-body">
                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background:#f8fafc;">
                            <tr>
                                <td align="center" style="padding:16pt 0;border:1px solid #d1d5db;">

                                    <div style="font-size:22pt;font-weight:800;color:#1f2933;line-height:1;">
                                        {{ $question->marks_awarded }}
                                        <span style="font-size:12pt;font-weight:600;color:#475569;">
                                            / {{ $question->max_marks }}
                                        </span>
                                    </div>

                                    <div style="font-size:10.5pt;color:#475569;margin-top:4pt;letter-spacing:0.3px;">
                                        TOTAL MARKS AWARDED
                                    </div>

                                </td>
                            </tr>
                    </table>
                </div>
            </div>
        @php($i++)
        @endforeach
        </div>
    </div>
</body>
</html>