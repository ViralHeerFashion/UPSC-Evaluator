@php($i = 1)
@foreach($student_answer_sheet->student_answer_evaluation as $question)
<div class="chat-content">
    <section class="evaluation-section">
        <p class="question-container">{{ $i }})&nbsp; {{ $question->question }}</p>
        {{-- 
        <p class="text-right">
            <span class="mark-container">{{ $question->marks_awarded }} / {{ $question->max_marks }} Marks</span>
        </p>
        --}}
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number-">
                <svg width="35px" height="35px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M215.412 747.654c0 20.425 16.557 36.983 36.983 36.983h30.761-30.761c-20.425 0-36.983 16.558-36.983 36.983v30.761-30.761c0-20.425-16.558-36.983-36.983-36.983h-30.761 30.761c20.424-0.001 36.983-16.558 36.983-36.983v-30.761 30.761z" fill="#ED8F27"></path><path d="M227.99 852.377h-25.154v-30.755c0-13.462-10.948-24.409-24.41-24.409h-30.763v-25.154h30.763c13.462 0 24.41-10.948 24.41-24.41v-30.754h25.154v30.754c0 13.462 10.947 24.41 24.4 24.41v25.154c-13.453 0-24.4 10.947-24.4 24.409v30.755z m-16.606-67.741a49.398 49.398 0 0 1 4.029 4.028 47.603 47.603 0 0 1 4.02-4.028 47.764 47.764 0 0 1-4.02-4.029 49.094 49.094 0 0 1-4.029 4.029z m71.77 12.577H252.39v-25.154h30.764v25.154z" fill="#ED8F27"></path><path d="M721.536 134.403c0 22.309 18.084 40.393 40.393 40.393h33.598-33.598c-22.309 0-40.393 18.085-40.393 40.394v33.598-33.598c0-22.309-18.085-40.394-40.394-40.394h-33.598 33.598c22.309 0 40.394-18.084 40.394-40.393v-33.598 33.598z" fill="#ED8F27"></path><path d="M735.275 248.784h-27.474v-33.591c0-14.703-11.958-26.66-26.661-26.66h-33.6v-27.474h33.6c14.703 0 26.661-11.958 26.661-26.661v-33.59h27.474v33.59c0 14.703 11.957 26.661 26.651 26.661v27.474c-14.694 0-26.651 11.957-26.651 26.66v33.591z m-18.138-73.988a53.875 53.875 0 0 1 4.4 4.399 52.217 52.217 0 0 1 4.39-4.399 52.08 52.08 0 0 1-4.39-4.4 53.888 53.888 0 0 1-4.4 4.4z m78.389 13.737h-33.6v-27.474h33.6v27.474z" fill="#ED8F27"></path><path d="M488.445 842.076h39.783v29.79h-39.783zM746.417 256.375h104.96v29.79h-104.96zM879.543 256.375h35.335v29.79h-35.335zM566.969 842.076h23.449v29.79h-23.449zM433.533 842.076h23.449v29.79h-23.449z" fill="#300604"></path><path d="M911.405 372.591v339.597l-102.581-0.632S704.592 833.938 705.788 833.75c1.196-0.188 0-123.314 0-123.314l-269.809 1.751V372.591h475.426z" fill="#FCE3C3"></path><path d="M699.002 722.731H423.641V361.913h498.444v360.818H813.782L699.002 855.4V722.731z m201.725-339.46H444.999v318.101H720.36v96.697l83.66-96.697h96.707V383.271z" fill="#300604"></path><path d="M696.574 861.92V725.159H421.212V359.484h503.302v365.675H814.892L696.574 861.92zM426.07 720.302h275.361v128.579l111.24-128.579h106.985v-355.96H426.07v355.96z m291.862 84.287V703.801H442.571V380.843h460.585v322.958h-98.025l-87.199 100.788zM447.428 698.943h275.361v92.606l80.121-92.606h95.388V385.7h-450.87v313.243z" fill="#300604"></path><path d="M658.299 372.903V245.987H110.875v344.052h87.393l88.483 100.92-1.169-100.92h147.937V372.903z" fill="#228E9D"></path><path d="M289.99 706.907L187.59 600.72h-87.394V235.306h568.781v148.278h-224.78V600.72H290.464l-0.474 106.187zM121.555 579.362h75.819l74.253 77.834 0.228-77.834h150.983V362.226h224.781V256.664H121.555v322.698z" fill="#300604"></path><path d="M292.392 712.896L186.559 603.148H97.768V232.877h573.639v153.136H446.625v217.136H292.882l-0.49 109.747zM102.625 598.291h85.997l98.966 102.627 0.458-102.627h153.721V381.155h224.781V237.734H102.625v360.557z m171.413 64.95l-77.703-81.451h-77.208V254.235h530.922v110.419H425.267V581.79H274.276l-0.238 81.451z m-150.055-86.308h74.43l70.802 74.217 0.218-74.217H420.41V359.797h224.78V259.093H123.983v317.84z" fill="#300604"></path><path d="M320.956 450.316c3.896 2.639 8.151 5.2 12.767 7.688 4.615 2.487 7.671 4.466 9.17 5.934 1.498 1.47 2.248 3.552 2.248 6.249 0 1.917-0.885 3.835-2.652 5.754-1.769 1.917-3.911 2.877-6.428 2.877-2.039 0-4.511-0.66-7.417-1.979-2.908-1.318-6.324-3.236-10.25-5.754-3.926-2.518-8.227-5.453-12.902-8.811-8.691 4.435-19.361 6.653-32.007 6.653-10.25 0-19.436-1.634-27.557-4.9-8.123-3.267-14.94-7.971-20.454-14.115-5.515-6.144-9.665-13.441-12.452-21.893s-4.181-17.651-4.181-27.602c0-10.129 1.453-19.421 4.36-27.872s7.117-15.644 12.632-21.578c5.514-5.934 12.228-10.474 20.139-13.621 7.912-3.146 16.903-4.72 26.973-4.72 13.666 0 25.399 2.773 35.199 8.316 9.8 5.545 17.217 13.428 22.252 23.646 5.035 10.221 7.552 22.223 7.552 36.009 0 20.92-5.664 37.492-16.992 49.719z m-20.949-14.565c3.716-4.255 6.458-9.29 8.227-15.104 1.768-5.812 2.652-12.556 2.652-20.229 0-9.65-1.559-18.012-4.675-25.085-3.117-7.071-7.567-12.421-13.351-16.048-5.785-3.626-12.423-5.439-19.915-5.439-5.335 0-10.265 1.004-14.79 3.012-4.526 2.009-8.422 4.931-11.688 8.766-3.268 3.837-5.844 8.736-7.732 14.7-1.888 5.965-2.832 12.663-2.832 20.095 0 15.164 3.536 26.837 10.609 35.019 7.072 8.182 16.004 12.272 26.792 12.272 4.435 0 8.991-0.929 13.666-2.787-2.818-2.098-6.338-4.194-10.564-6.294-4.226-2.097-7.118-3.715-8.676-4.854-1.559-1.138-2.337-2.756-2.337-4.855 0-1.798 0.749-3.385 2.248-4.765 1.498-1.378 3.147-2.068 4.945-2.068 5.453-0.002 14.594 4.555 27.421 13.664z" fill="#ED8F27"></path><path d="M336.06 481.246c-2.409 0-5.164-0.718-8.421-2.195-3-1.36-6.552-3.353-10.557-5.922-3.621-2.321-7.593-5.021-11.822-8.034-8.756 4.156-19.437 6.262-31.775 6.262-10.513 0-20.089-1.708-28.463-5.076-8.433-3.391-15.618-8.353-21.355-14.746-5.713-6.364-10.071-14.02-12.951-22.754-2.855-8.657-4.303-18.2-4.303-28.362 0-10.354 1.511-19.998 4.493-28.662 3.004-8.734 7.428-16.285 13.149-22.441 5.734-6.171 12.807-10.957 21.021-14.225 8.163-3.246 17.539-4.892 27.871-4.892 14.024 0 26.269 2.904 36.395 8.631 10.186 5.764 18.003 14.068 23.235 24.687 5.177 10.51 7.802 22.986 7.802 37.082 0 20.268-5.297 36.813-15.753 49.233a151.194 151.194 0 0 0 10.25 6.035c4.859 2.619 8.038 4.691 9.718 6.336 1.976 1.939 2.977 4.625 2.977 7.984 0 2.536-1.108 5.026-3.294 7.399-2.243 2.429-5.007 3.66-8.217 3.66z m-30.354-21.808l1.202 0.863c4.605 3.307 8.91 6.247 12.796 8.738 3.809 2.443 7.154 4.323 9.941 5.587 2.578 1.169 4.736 1.762 6.415 1.762 1.849 0 3.324-0.666 4.643-2.095 1.333-1.447 2.009-2.829 2.009-4.107 0-2.035-0.497-3.512-1.52-4.516-0.913-0.895-3.152-2.581-8.622-5.529-4.671-2.517-9.038-5.146-12.977-7.814l-2.342-1.586 1.922-2.075c10.846-11.707 16.346-27.88 16.346-48.068 0-13.345-2.457-25.099-7.302-34.936-4.793-9.726-11.949-17.331-21.27-22.604-9.387-5.31-20.827-8.002-34.003-8.002-9.714 0-18.487 1.53-26.075 4.548-7.539 2.999-14.018 7.379-19.257 13.018-5.257 5.656-9.333 12.626-12.115 20.715-2.806 8.154-4.229 17.267-4.229 27.082 0 9.645 1.365 18.675 4.059 26.841 2.669 8.093 6.69 15.169 11.953 21.031 5.237 5.836 11.816 10.372 19.553 13.484 7.795 3.135 16.762 4.725 26.651 4.725 12.198 0 22.595-2.149 30.903-6.388l1.319-0.674z m-32.402-9.3c-11.477 0-21.109-4.412-28.63-13.113-7.432-8.596-11.2-20.912-11.2-36.606 0-7.646 0.991-14.654 2.945-20.828 1.978-6.247 4.736-11.477 8.198-15.541 3.489-4.098 7.712-7.264 12.552-9.411 4.816-2.137 10.124-3.221 15.775-3.221 7.919 0 15.053 1.955 21.205 5.811 6.175 3.872 10.981 9.635 14.283 17.126 3.239 7.353 4.882 16.122 4.882 26.064 0 7.875-0.928 14.918-2.757 20.936-1.861 6.118-4.795 11.5-8.721 15.995l-1.444 1.654-1.791-1.271c-15.383-10.925-22.638-13.218-26.016-13.218-1.177 0-2.257 0.467-3.3 1.427-0.998 0.919-1.463 1.865-1.463 2.978 0 1.325 0.414 2.217 1.34 2.894 1.44 1.054 4.24 2.614 8.324 4.641 4.339 2.156 8.018 4.351 10.935 6.521l3.49 2.598-4.043 1.607c-4.94 1.962-9.84 2.957-14.564 2.957z m-0.359-93.864c-4.969 0-9.613 0.943-13.805 2.803-4.169 1.851-7.811 4.583-10.824 8.121-3.04 3.568-5.484 8.231-7.266 13.858-1.804 5.698-2.719 12.213-2.719 19.361 0 14.494 3.371 25.741 10.018 33.43 6.649 7.693 14.812 11.433 24.955 11.433 2.662 0 5.403-0.37 8.191-1.103a82.858 82.858 0 0 0-6.17-3.375c-4.391-2.179-7.345-3.837-9.03-5.069-2.179-1.59-3.332-3.947-3.332-6.815 0-2.496 1.02-4.7 3.031-6.552 1.955-1.798 4.172-2.71 6.59-2.71 5.743 0 14.578 4.194 26.975 12.812 2.786-3.618 4.918-7.822 6.35-12.529 1.69-5.558 2.547-12.126 2.547-19.521 0-9.265-1.503-17.375-4.469-24.105-2.903-6.586-7.082-11.623-12.419-14.97-5.364-3.364-11.631-5.069-18.623-5.069z" fill="#ED8F27"></path><path d="M624.43 637.357l-33.173-14.077 87.555-206.489 86.981 206.536-33.222 13.983-53.876-127.944z" fill="#B12800"></path><path d="M632.618 552.594h88.915v36.036h-88.915z" fill="#B12800"></path></g></svg>
            </div>
            <h6 class="title">Question Deconstruction</h6>
        </div>
        <div class="section-content">
            <p>{{ $question->deconstruction }}</p>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number-">
                <svg width="35px" height="35px" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16,29a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,16,29Z" fill="#ffba00"></path><path d="M4.5,18.5A1.5,1.5,0,0,1,3,17V15a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,4.5,18.5Z" fill="#0066da"></path><path d="M27.5,18.5A1.5,1.5,0,0,1,26,17V15a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,27.5,18.5Z" fill="#4285f4"></path><path d="M16,8a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,16,8Z" fill="#ffba00"></path><path d="M10.25,24.5A1.5,1.5,0,0,1,8.75,23V21a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,10.25,24.5Z" fill="#ea4435"></path><path d="M10.25,17a1.5,1.5,0,0,1-1.5-1.5v-6a1.5,1.5,0,0,1,3,0v6A1.5,1.5,0,0,1,10.25,17Z" fill="#ea4435"></path><path d="M16,22a1.5,1.5,0,0,1-1.5-1.5v-9a1.5,1.5,0,0,1,3,0v9A1.5,1.5,0,0,1,16,22Z" fill="#ffba00"></path><path d="M21.75,12.75a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,21.75,12.75Z" fill="#00ac47"></path><path d="M21.75,24.25a1.5,1.5,0,0,1-1.5-1.5v-6a1.5,1.5,0,0,1,3,0v6A1.5,1.5,0,0,1,21.75,24.25Z" fill="#00ac47"></path></g></svg>
            </div>
            <h6 class="title">Micro-Marking Grid</h6>
        </div>
        <div class="section-content">
            <div class="marking-grid-container">
                <table class="marking-grid table-striped text-center">
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
                        @foreach($question->micro_marking_grid as $marking_grid)
                        <tr>
                            <td class="component-name">{{ $marking_grid->component }}</td>
                            <td>{{ $marking_grid->weight }}%</td>
                            <td>{{ $marking_grid->max_marks }}</td>
                            <td>{{ $marking_grid->marks_awarded }}</td>
                            <td>{{ $marking_grid->justifications }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number-">
                <svg height="35px" width="35px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-66.17 -66.17 573.45 573.45" xml:space="preserve" fill="#ffffff" transform="rotate(180)matrix(1, 0, 0, 1, 0, 0)" stroke="#ffffff" stroke-width="2.20554"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="10.586592"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#D60949;" d="M441.108,417.477c0,13.044-10.587,23.631-23.631,23.631H23.631C10.587,441.108,0,430.521,0,417.477 V23.631C0,10.571,10.587,0,23.631,0h393.846c13.044,0,23.631,10.571,23.631,23.631V417.477z"></path> <path style="fill:#B70243;" d="M0,23.631C0,10.571,10.587,0,23.631,0h393.846c13.044,0,23.631,10.571,23.631,23.631v393.846 c0,13.044-10.587,23.631-23.631,23.631"></path> <polygon style="fill:#FFD31A;" points="314.415,99.769 230.4,99.769 126.692,252.062 187.479,252.062 126.692,341.323 210.708,341.323 314.415,189.046 253.629,189.046 "></polygon> <polygon style="fill:#FF9E1D;" points="230.4,99.769 167.904,191.535 254.054,277.677 314.415,189.046 253.629,189.046 314.415,99.769 "></polygon> </g></svg>
            </div>
            <h6 class="title">Strengths Snapshot</h6>
        </div>
        <div class="section-content">
            <ul class="evaluation-list- -strengths-list strength-snapshot-list">
                @foreach($question->strength_snapshot as $snapshot)
                <li>
                    <svg width="30px" height="30px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <path id="check-a" d="M4.29289322,0.292893219 C4.68341751,-0.0976310729 5.31658249,-0.0976310729 5.70710678,0.292893219 C6.09763107,0.683417511 6.09763107,1.31658249 5.70710678,1.70710678 L1.90917969,5.46118164 C1.5186554,5.85170593 0.885490417,5.85170593 0.494966125,5.46118164 C0.104441833,5.07065735 0.104441833,4.43749237 0.494966125,4.04696808 L4.29289322,0.292893219 Z"></path> <path id="check-c" d="M10.7071068,13.2928932 C11.0976311,13.6834175 11.0976311,14.3165825 10.7071068,14.7071068 C10.3165825,15.0976311 9.68341751,15.0976311 9.29289322,14.7071068 L0.292893219,5.70710678 C-0.0976310729,5.31658249 -0.0976310729,4.68341751 0.292893219,4.29289322 L4.29289322,0.292893219 C4.68341751,-0.0976310729 5.31658249,-0.0976310729 5.70710678,0.292893219 C6.09763107,0.683417511 6.09763107,1.31658249 5.70710678,1.70710678 L2.41421356,5 L10.7071068,13.2928932 Z"></path> </defs> <g fill="none" fill-rule="evenodd" transform="rotate(-90 11 7)"> <g transform="translate(1 1)"> <mask id="check-b" fill="#ffffff"> <use xlink:href="#check-a"></use> </mask> <use fill="#D8D8D8" fill-rule="nonzero" xlink:href="#check-a"></use> <g fill="#FFA0A0" mask="url(#check-b)"> <rect width="24" height="24" transform="translate(-7 -5)"></rect> </g> </g> <mask id="check-d" fill="#ffffff"> <use xlink:href="#check-c"></use> </mask> <use fill="#000000" fill-rule="nonzero" xlink:href="#check-c"></use> <g fill="#7600FF" mask="url(#check-d)"> <rect width="24" height="24" transform="translate(-6 -4)"></rect> </g> </g> </g></svg>
                    {{ $snapshot->snapshot }}
                </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number-">
                <svg width="35px" height="35px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style>
                            .cls-1{fill:#4285F4;}
                            .cls-2{fill:#EA4335;}
                            .cls-3{fill:#FBBC05;}
                            .cls-4{fill:#34A853;}
                            .cls-5{fill:#AECBFA;}
                            .cls-1,.cls-2,.cls-3,.cls-4,.cls-5{fill-rule:evenodd;}
                        </style>
                    </defs>
                    <g data-name="Product Icons">
                        <g>
                            <polygon class="cls-1" points="14.68 13.06 19.23 15.69 19.23 16.68 14.29 13.83 14.68 13.06"></polygon>
                            <polygon class="cls-1" points="12.48 12.3 12.48 16.89 16.34 14.6 16.34 10.01 12.48 12.3"></polygon>
                            
                            <polygon class="cls-2" points="9.98 13.65 4.77 16.66 4.45 15.86 9.53 12.92 9.98 13.65"></polygon>
                            
                            <rect class="cls-3" x="11.55" y="3.29" width="0.86" height="5.78"></rect>
                            
                            <path class="cls-4" d="M3.25,7V17L12,22l8.74-5V7L12,2Zm15.63,8.89L12,19.78,5.12,15.89V8.11L12,4.22l6.87,3.89v7.78Z"></path>
                            <polygon class="cls-4" points="11.98 11.5 15.96 9.21 11.98 6.91 8.01 9.21 11.98 11.5"></polygon>
                            
                            <polygon class="cls-5" points="11.52 12.3 7.66 10.01 7.66 14.6 11.52 16.89 11.52 12.3"></polygon>
                        </g>
                    </g>
                </svg>
            </div>
            <h6 class="title">Gap Analysis & Priority Fixes</h6>
        </div>
        <div class="section-content">
            <div class="gap-items-container">
                @php($j = 1)
                @foreach($question->gap_analysis_priority_fix as $gap_analysis_priority_fix)
                <div class="gap-item">
                    <div class="gap-title">
                        <div class="gap-number-">
                            <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M832 384l8 1.6-1.6 8 1.6 3.2-4.8 3.2-44.8 161.6-16-4.8 40-147.2-260.8 144-158.4 284.8-11.2-6.4-6.4 6.4-176-176 11.2-11.2 163.2 163.2 147.2-265.6-294.4-297.6 11.2-11.2v-8h9.6l3.2-3.2 3.2 3.2L664 208l1.6 16-395.2 22.4 278.4 278.4 276.8-153.6 6.4 12.8z" fill="#e8eaf7"></path><path d="M896 384c0 35.2-28.8 64-64 64s-64-28.8-64-64 28.8-64 64-64 64 28.8 64 64z m-656-32c-62.4 0-112-49.6-112-112s49.6-112 112-112 112 49.6 112 112-49.6 112-112 112z m304 336c-80 0-144-64-144-144s64-144 144-144 144 64 144 144-64 144-144 144z m-224 144c0-35.2 28.8-64 64-64s64 28.8 64 64-28.8 64-64 64-64-28.8-64-64z m-144-176c0-17.6 14.4-32 32-32s32 14.4 32 32-14.4 32-32 32-32-14.4-32-32z m448-440c0-22.4 17.6-40 40-40s40 17.6 40 40-17.6 40-40 40-40-17.6-40-40zM736 560c0-27.2 20.8-48 48-48s48 20.8 48 48-20.8 48-48 48-48-20.8-48-48z" fill="#e13d7e"></path></g></svg>
                        </div>
                        <h4>{{ $gap_analysis_priority_fix->gap }}</h4>
                    </div>
                    
                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot-" style="">
                                <svg width="17px" height="17px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M972.011 899.734H55.013c-25.786 0-46.682 23.455-46.682 52.39v3.743c0 28.935 20.896 52.389 46.682 52.389h916.998c25.787 0 46.684-23.454 46.684-52.389v-3.743c-0.001-28.935-20.897-52.39-46.684-52.39z" fill="#C45FA0"></path><path d="M66.007 15.343h-3.744c-28.934 0-52.389 20.589-52.389 45.994V964.75c0 25.404 23.455 45.993 52.389 45.993h3.744c28.934 0 52.389-20.589 52.389-45.993V61.336c0-25.404-23.455-45.993-52.389-45.993z" fill="#4A5699"></path><path d="M309.615 402.957h-3.743c-28.935 0-52.389 21.033-52.389 46.966v470.815c0 25.941 23.454 46.971 52.389 46.971h3.743c28.936 0 52.39-21.028 52.39-46.971V449.923c-0.001-25.933-23.455-46.966-52.39-46.966z" fill="#F0D043"></path><path d="M571.563 298.496h-3.744c-28.935 0-52.389 21.028-52.389 46.97v575.273c0 25.941 23.454 46.971 52.389 46.971h3.744c28.934 0 52.389-21.028 52.389-46.971V345.465c-0.001-25.942-23.456-46.969-52.389-46.969z" fill="#F39A2B"></path><path d="M833.508 118.95h-3.738c-28.938 0-52.393 21.028-52.393 46.97v754.818c0 25.941 23.453 46.971 52.393 46.971h3.738c28.939 0 52.39-21.028 52.39-46.971V165.92c-0.001-25.941-23.45-46.97-52.39-46.97z" fill="#E5594F"></path></g></svg>
                            </div>
                            <h5>Impact Analysis</h5>
                        </div>
                        <p class="section-text ml-10px">{{ $gap_analysis_priority_fix->impact }}</p>
                    </div>

                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot-" style="">
                                <svg width="17px" height="17px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M330.147 727.583l-3.105-2.113c-23.995-16.366-56.736-10.206-73.12 13.753L120.381 934.43c-16.389 23.958-10.22 56.646 13.779 73.002l3.1 2.118c24 16.366 56.741 10.206 73.125-13.752l133.542-195.207c16.388-23.959 10.219-56.642-13.78-73.008z" fill="#E5594F"></path><path d="M457.934 727.583l-3.1-2.113c-23.999-16.366-56.74-10.206-73.129 13.753L248.168 934.43c-16.388 23.958-10.22 56.646 13.775 73.002l3.109 2.118c23.995 16.366 56.736 10.206 73.12-13.752l133.537-195.207c16.394-23.959 10.225-56.642-13.775-73.008z" fill="#F0D043"></path><path d="M895.09 934.213L761.813 740.007c-16.353-23.837-49.03-29.961-72.979-13.689l-3.101 2.108c-23.949 16.28-30.104 48.796-13.748 72.629L805.26 995.261c16.357 23.838 49.031 29.971 72.98 13.686l3.101-2.1c23.95-16.282 30.105-48.797 13.749-72.634z" fill="#E5594F"></path><path d="M767.555 934.213L634.279 740.007c-16.357-23.837-49.031-29.961-72.985-13.689l-3.096 2.108c-23.954 16.28-30.109 48.796-13.752 72.629l133.275 194.206c16.357 23.838 49.03 29.971 72.984 13.686l3.096-2.1c23.955-16.282 30.11-48.797 13.754-72.634z" fill="#F0D043"></path><path d="M712.252 364.688L577.453 338.78l-66.275-120.278-66.28 120.278-134.794 25.908 93.834 100.25-17.037 136.291 124.277-58.327 124.272 58.327-17.037-136.291z" fill="#F39A2B"></path><path d="M803.625 434.496c-1.459 160.596-131.855 290.993-292.452 292.453-76.346 0.693-150.076-30.799-204.647-83.529-56.995-55.073-87.084-130.821-87.796-208.923-0.676-74.35-116.033-74.415-115.355 0 2.034 223.497 184.3 405.775 407.798 407.807 223.519 2.032 405.803-187.375 407.808-407.807 0.675-74.416-114.679-74.351-115.356-0.001z" fill="#4A5699"></path><path d="M218.73 415.399c1.462-160.594 131.845-290.992 292.443-292.455 76.347-0.696 150.079 30.801 204.647 83.531 56.997 55.075 87.093 130.822 87.805 208.923 0.677 74.35 116.031 74.416 115.355 0C916.948 191.905 734.669 9.624 511.173 7.589c-223.518-2.035-405.793 187.38-407.798 407.81-0.678 74.415 114.679 74.35 115.355 0z" fill="#C45FA0"></path></g></svg>
                            </div>
                            <h5>Optimal Solution</h5>
                        </div>
                        <p class="section-text ml-10px">{{ $gap_analysis_priority_fix->correct_action }}</p>
                    </div>
                </div>
                @php($j++)
                @endforeach
            </div>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number-">
                <!-- 6 -->
                <svg width="35px" height="35px" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><circle cx="10.5" cy="11.5" fill="#4285f4" r="6.5"></circle><circle cx="21.5" cy="15" fill="#ea4435" r="3"></circle><circle cx="21.5" cy="24" fill="#fbc02d" r="4"></circle><circle cx="26.5" cy="11" fill="#00ac47" r="1.5"></circle></g></svg>
            </div>
            <h6 class="title">Model Answer</h6>
        </div>
        <div class="section-content model-answer-container">
            <div class="model-answer-card">
                @if(!empty($question->model_answer_intro))
                <p class="p-3 m-auto mb-3">{{ $question->model_answer_intro }}</p>
                @endif
                @foreach($question->model_answer as $model_answer)
                <div class="model-title-wrapper">
                    <div class="model-icon">
                        <!-- <i class="fas fa-brain"></i> -->
                        <svg width="64px" height="64px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" transform="matrix(1, 0, 0, -1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M512 960c-92.8 0-160-200-160-448S419.2 64 512 64s160 200 160 448-67.2 448-160 448z m0-32c65.6 0 128-185.6 128-416S577.6 96 512 96s-128 185.6-128 416 62.4 416 128 416z" fill="#c2caff"></path><path d="M124.8 736c-48-80 92.8-238.4 307.2-363.2S852.8 208 899.2 288 806.4 526.4 592 651.2 171.2 816 124.8 736z m27.2-16c33.6 57.6 225.6 17.6 424-97.6S905.6 361.6 872 304 646.4 286.4 448 401.6 118.4 662.4 152 720z" fill="#c2caff"></path><path d="M899.2 736c-46.4 80-254.4 38.4-467.2-84.8S76.8 368 124.8 288s254.4-38.4 467.2 84.8S947.2 656 899.2 736z m-27.2-16c33.6-57.6-97.6-203.2-296-318.4S184 246.4 152 304 249.6 507.2 448 622.4s392 155.2 424 97.6z" fill="#c2caff"></path><path d="M512 592c-44.8 0-80-35.2-80-80s35.2-80 80-80 80 35.2 80 80-35.2 80-80 80zM272 312c-27.2 0-48-20.8-48-48s20.8-48 48-48 48 20.8 48 48-20.8 48-48 48zM416 880c-27.2 0-48-20.8-48-48s20.8-48 48-48 48 20.8 48 48-20.8 48-48 48z m448-432c-27.2 0-48-20.8-48-48s20.8-48 48-48 48 20.8 48 48-20.8 48-48 48z" fill="#8192fd"></path></g></svg>
                    </div>
                    <h5 class="model-title">{{ $model_answer->title }}</h5>
                </div>
                <p class="model-description">{{ $model_answer->description }}</p>
                @endforeach
                @if(!empty($question->model_answer_conclusion))
                <p class="p-3 m-auto mb-3">{{ $question->model_answer_conclusion }}</p>
                @endif
            </div>
        </div>
    </section>
</div>
<div class="chat-content custom-margin-bottom">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number-">
                <!-- 7 -->
                <svg width="35px" height="35px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle fill="#F0C419" cx="50" cy="50" r="50"></circle> <clipPath id="a"> <circle cx="50" cy="50" r="50"></circle> </clipPath> <g fill-rule="evenodd" clip-rule="evenodd" clip-path="url(#a)"> <path fill="#FCF062" d="M7.619 21.663L49.999 50 21.689 7.594 7.619 21.663zm84.775.019L78.329 7.607 50 50 .005 40.039 0 59.94 50 50 7.606 78.319l14.065 14.075L50 50.001l-9.958 50.01 19.895.004L50 50.001l28.31 42.406 14.071-14.07L50 50l42.394-28.318zM100 40.061L50 50l49.996 9.962.004-19.901zM40.063-.014L50 49.999 59.958-.01 40.063-.014z"></path> <path fill="#FCF062" stroke="#F29C1F" stroke-width="4" stroke-miterlimit="10" d="M60 93H40c0-7.575-3.487-17.565-7.99-21.324A28.114 28.114 0 0 1 22 50.125C22 34.592 34.536 22 50 22s28 12.592 28 28.125c0 8.667-4.156 16.13-10.04 21.576C63.191 76.47 60 85.466 60 93z"></path> <path fill="#F29C1F" d="M53 95a1 1 0 0 1-1-1V61h-4v33a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V61h-2.5c-3.584 0-6.5-2.916-6.5-6.5s2.916-6.5 6.5-6.5a6.46 6.46 0 0 1 6.446 5.684A.949.949 0 0 1 48 54v3h4v-3c0-.115.02-.226.056-.329A6.46 6.46 0 0 1 58.5 48c3.584 0 6.5 2.916 6.5 6.5S62.084 61 58.5 61H56v33a1 1 0 0 1-1 1h-2zm5.5-38c1.379 0 2.5-1.121 2.5-2.5s-1.121-2.501-2.5-2.501a2.504 2.504 0 0 0-2.459 2.144l-.041.173V57h2.5zm-17-5.001c-1.378 0-2.5 1.122-2.5 2.501s1.122 2.5 2.5 2.5H44v-2.692l-.04-.165a2.505 2.505 0 0 0-2.46-2.144z"></path> <path fill="#E57E25" d="M38 91h24v9H38v-9zm6-27h4v-3h-4v3zm8-3v3h4v-3h-4z"></path> </g> </g></svg>
            </div>
            <h6 class="title">Marks Breakdown</h6>
        </div>
        <div class="section-content">
            <div class="dashboard" data-score="{{ $question->marks_awarded }}" data-total="{{ $question->max_marks }}">
                <div class="progress-container">
                    <div class="score-section">
                        <div class="emoji-container"></div>
                        <div class="score-display">
                            <div class="score-value"></div>
                            <div class="score-label">Marks Scored</div>
                        </div>
                    </div>
                    
                    <div class="progress-section">
                        <div class="position-indicator">You are here</div>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                        
                        <div class="markers"></div>
                    </div>
                    
                    <div class="message-section">
                        <div class="message-title"></div>
                        <div class="message-content"></div>
                        <!-- <button class="action-button">
                            <i class="fas fa-arrow-right"></i> Continue Learning
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@php($i++)
@endforeach