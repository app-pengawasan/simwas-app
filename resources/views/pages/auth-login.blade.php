@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
@endpush

@section('main')
    <div class="container">
        <div class="row py-5 mt-4 align-items-center">
            <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
                <svg class="animated" id="freepik_stories-information-tab" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500" version="1.1"
                    xmlns:svgjs="http://svgjs.com/svgjs">
                    <style>
                        svg#freepik_stories-information-tab:not(.animated) .animable {
                            opacity: 0;
                        }

                        svg#freepik_stories-information-tab.animated #freepik--background-simple--inject-2 {
                            animation: 6s Infinite linear wind;
                            animation-delay: 0s;
                        }

                        svg#freepik_stories-information-tab.animated #freepik--Graphics--inject-2 {
                            animation: 3s Infinite linear floating;
                            animation-delay: 0s;
                        }

                        svg#freepik_stories-information-tab.animated #freepik--Screens--inject-2 {
                            animation: 1.5s Infinite linear wind;
                            animation-delay: 0s;
                        }

                        @keyframes wind {
                            0% {
                                transform: rotate(0deg);
                            }

                            25% {
                                transform: rotate(1deg);
                            }

                            75% {
                                transform: rotate(-1deg);
                            }
                        }

                        @keyframes floating {
                            0% {
                                opacity: 1;
                                transform: translateY(0px);
                            }

                            50% {
                                transform: translateY(-10px);
                            }

                            100% {
                                opacity: 1;
                                transform: translateY(0px);
                            }
                        }
                    </style>
                    <g id="freepik--background-simple--inject-2" class="animable"
                        style="transform-origin: 249.593px 238.846px;">
                        <path
                            d="M479.58,213.15c-1-6.19-2.19-12.27-3.49-18.19C465.49,146.77,441,95.64,393,76.18,337.78,53.8,259.4,60,210,103.71c-38,33.6-115,53.88-158,104.82C7.43,261.34-1.88,360.31,56,400.26c41.17,28.41,92.07,6,137.92-3.39,26.11-5.34,48.71-2.32,74.45,0,44.73,4,91.06,7,136.17-3,22.28-5,42.09-14.06,54.65-34.72C485.57,315.7,487.39,261,479.58,213.15Z"
                            style="fill: rgb(0, 105, 217); transform-origin: 249.593px 238.846px;" id="elqt15t8rvv6"
                            class="animable"></path>
                        <g id="elhf8yv8x6e65">
                            <path
                                d="M479.58,213.15c-1-6.19-2.19-12.27-3.49-18.19C465.49,146.77,441,95.64,393,76.18,337.78,53.8,259.4,60,210,103.71c-38,33.6-115,53.88-158,104.82C7.43,261.34-1.88,360.31,56,400.26c41.17,28.41,92.07,6,137.92-3.39,26.11-5.34,48.71-2.32,74.45,0,44.73,4,91.06,7,136.17-3,22.28-5,42.09-14.06,54.65-34.72C485.57,315.7,487.39,261,479.58,213.15Z"
                                style="fill: rgb(255, 255, 255); opacity: 0.7; transform-origin: 249.593px 238.846px;"
                                class="animable"></path>
                        </g>
                    </g>
                    <g id="freepik--Graphics--inject-2" class="animable" style="transform-origin: 237.5px 240.43px;">
                        <path d="M49,323h54a6,6,0,0,1,6,6h0a6,6,0,0,1-6,6H42a6,6,0,0,1-6-6h0a6,6,0,0,1,6-6h1.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 72.5px 329px;"
                            id="eli60rnkrgvo" class="animable"></path>
                        <path d="M91,342.85h12a6,6,0,0,1,6,6h0a6,6,0,0,1-6,6H42a6,6,0,0,1-6-6h0a6,6,0,0,1,6-6H85.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 72.5px 348.85px;"
                            id="eletdmkih60ac" class="animable"></path>
                        <path d="M103,374.71H42a6,6,0,0,1-6-6h0a6,6,0,0,1,6-6h61a6,6,0,0,1,6,6h0A6,6,0,0,1,103,374.71Z"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 72.5px 368.71px;"
                            id="elwl3qyzpog5d" class="animable"></path>
                        <polyline points="85.5 303 116 303 116 385.5 75.5 385.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 95.75px 344.25px;"
                            id="elomjhb4c17c" class="animable"></polyline>
                        <polyline points="42.5 385.5 29.5 385.5 29.5 303 78.5 303"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 54px 344.25px;"
                            id="eleirikrnab4c" class="animable"></polyline>
                        <line x1="68.5" y1="385.5" x2="47.5" y2="385.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 58px 385.5px;"
                            id="el4fs2x90jctw" class="animable"></line>
                        <line x1="34" y1="315" x2="111" y2="315"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 72.5px 315px;"
                            id="eloc5fntqr16" class="animable"></line>
                        <path d="M125,54.15h54a6,6,0,0,1,6,6h0a6,6,0,0,1-6,6H118a6,6,0,0,1-6-6h0a6,6,0,0,1,6-6h1.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 148.5px 60.15px;"
                            id="el0itx9iu0ldh" class="animable"></path>
                        <path d="M167,74h12a6,6,0,0,1,6,6h0a6,6,0,0,1-6,6H118a6,6,0,0,1-6-6h0a6,6,0,0,1,6-6h43.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 148.5px 80px;"
                            id="elunlbn8isky" class="animable"></path>
                        <rect x="112" y="93.85" width="73" height="12" rx="6"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 148.5px 99.85px;"
                            id="elktmb79dfdws" class="animable"></rect>
                        <polyline points="161.5 34.15 192 34.15 192 116.65 151.5 116.65"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 171.75px 75.4px;"
                            id="elmy516fhdjuo" class="animable"></polyline>
                        <polyline points="118.5 116.65 105.5 116.65 105.5 34.15 154.5 34.15"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 130px 75.4px;"
                            id="elljojklf53k" class="animable"></polyline>
                        <line x1="144.5" y1="116.65" x2="123.5" y2="116.65"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 134px 116.65px;"
                            id="eldkfb7rpc4qe" class="animable"></line>
                        <line x1="110" y1="46.15" x2="187" y2="46.15"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 148.5px 46.15px;"
                            id="elhu247z2uub7" class="animable"></line>
                        <path
                            d="M376.05,73.33H344.52a2.41,2.41,0,0,1-2.41-2.41V61.76a2.41,2.41,0,0,1,2.41-2.41h42.25a2.41,2.41,0,0,1,2.41,2.41v3.59"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 365.645px 66.34px;"
                            id="elt51cyztngo" class="animable"></path>
                        <path d="M375.75,88.23V68.64a3.15,3.15,0,0,1,3.14-3.14h41.84a3.15,3.15,0,0,1,3.14,3.14V92.1"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 399.81px 78.8px;"
                            id="elj1dqa844hz" class="animable"></path>
                        <path d="M423.87,111.42v24.44a3.15,3.15,0,0,1-3.14,3.14H378.89a3.15,3.15,0,0,1-3.14-3.14V92.93"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 399.81px 115.965px;"
                            id="ele2ukidhuvji" class="animable"></path>
                        <line x1="378.72" y1="76.95" x2="420.87" y2="76.95"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 399.795px 76.95px;"
                            id="elgjeu1qzxk6" class="animable"></line>
                        <line x1="398.86" y1="89.66" x2="420.87" y2="89.66"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 409.865px 89.66px;"
                            id="eloms1s1v4229" class="animable"></line>
                        <line x1="378.72" y1="89.66" x2="395.42" y2="89.66"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 387.07px 89.66px;"
                            id="eliwjmg08zto" class="animable"></line>
                        <line x1="378.72" y1="102.37" x2="420.87" y2="102.37"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 399.795px 102.37px;"
                            id="el899q56go54x" class="animable"></line>
                        <line x1="413.32" y1="115.08" x2="420.87" y2="115.08"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 417.095px 115.08px;"
                            id="elpx5umt92kq" class="animable"></line>
                        <line x1="378.72" y1="115.08" x2="409.52" y2="115.08"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 394.12px 115.08px;"
                            id="el1w9xb9947p7" class="animable"></line>
                        <line x1="378.72" y1="127.8" x2="420.87" y2="127.8"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 399.795px 127.8px;"
                            id="elx1jb1xsj4m" class="animable"></line>
                        <line x1="350.62" y1="66.02" x2="373.59" y2="66.02"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 362.105px 66.02px;"
                            id="elrvz45yx39gf" class="animable"></line>
                        <path
                            d="M214.1,356.18H170.64a3.33,3.33,0,0,1-3.33-3.32V340.23a3.33,3.33,0,0,1,3.33-3.33h58.23a3.33,3.33,0,0,1,3.33,3.33v4.95"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 199.755px 346.54px;"
                            id="el6nkozvery8j" class="animable"></path>
                        <path d="M213.69,376.73v-27a4.33,4.33,0,0,1,4.33-4.33h57.67a4.33,4.33,0,0,1,4.33,4.33v32.35"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 246.855px 363.74px;"
                            id="elugoow8s5zhi" class="animable"></path>
                        <path d="M280,408.69v33.69a4.33,4.33,0,0,1-4.33,4.33H218a4.33,4.33,0,0,1-4.33-4.33V383.2"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 246.835px 414.955px;"
                            id="elyboi161gqk" class="animable"></path>
                        <line x1="217.78" y1="361.17" x2="275.89" y2="361.17"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 246.835px 361.17px;"
                            id="elouymb9tb6b" class="animable"></line>
                        <line x1="245.54" y1="378.69" x2="275.89" y2="378.69"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 260.715px 378.69px;"
                            id="elclnj53435c" class="animable"></line>
                        <line x1="217.78" y1="378.69" x2="240.81" y2="378.69"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 229.295px 378.69px;"
                            id="elt65f9jc27f" class="animable"></line>
                        <line x1="217.78" y1="396.22" x2="275.89" y2="396.22"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 246.835px 396.22px;"
                            id="elf7l27soy7ma" class="animable"></line>
                        <line x1="265.48" y1="413.74" x2="275.89" y2="413.74"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 270.685px 413.74px;"
                            id="elmk1dzd192k" class="animable"></line>
                        <line x1="217.78" y1="413.74" x2="260.24" y2="413.74"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 239.01px 413.74px;"
                            id="ellzvjyyfmxuk" class="animable"></line>
                        <line x1="217.78" y1="431.26" x2="275.89" y2="431.26"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 246.835px 431.26px;"
                            id="elp2icj9lc868" class="animable"></line>
                        <line x1="179.05" y1="346.11" x2="210.71" y2="346.11"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 194.88px 346.11px;"
                            id="elk5i60lspph" class="animable"></line>
                        <path
                            d="M288.66,410.43a9.59,9.59,0,0,1-6.68-2.7l-6.19-6.14a2.24,2.24,0,0,1,3.11-3.22l1.22,1.14-6.23-12.81a2.7,2.7,0,0,1-.08-2.07,2.65,2.65,0,0,1,4.87-.2L281,389a2.74,2.74,0,0,1,1.66-1,3.6,3.6,0,0,1,2.46.71,2.68,2.68,0,0,1,1.74-1,3.23,3.23,0,0,1,2.08.5,1.75,1.75,0,0,1,1.82-1.1,2.51,2.51,0,0,1,2,1.32l4.4,8.09a9.6,9.6,0,0,1-8.55,13.95Zm-11.29-11.67h-.16a1.24,1.24,0,0,0-.72,2.11l6.19,6.13a8.59,8.59,0,0,0,13.64-10.07l-4.38-8.07a1.51,1.51,0,0,0-1.2-.8c-.41,0-.85.07-1,1l-.15.91-.68-.62a2.75,2.75,0,0,0-1.9-.69,2,2,0,0,0-1.35,1l-.32.51-.45-.41a3,3,0,0,0-2.07-.8,2.16,2.16,0,0,0-1.45,1.2l-.48.83-3.12-6.16a1.65,1.65,0,0,0-3,1.41l8.45,17.55-5-4.72A1.21,1.21,0,0,0,277.37,398.76Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 285.922px 396.695px;" id="elpx3kfwd58p"
                            class="animable"></path>
                        <path
                            d="M283.24,395.86a.51.51,0,0,1-.46-.31l-2.3-5.41a.51.51,0,0,1,.27-.66.5.5,0,0,1,.65.27l2.3,5.41a.5.5,0,0,1-.26.66A.45.45,0,0,1,283.24,395.86Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 282.092px 392.652px;" id="el8c1vsytl4kr"
                            class="animable"></path>
                        <path
                            d="M287.25,394.67a.5.5,0,0,1-.46-.3l-2-4.75a.5.5,0,0,1,.26-.66.52.52,0,0,1,.66.27l2,4.75a.49.49,0,0,1-.27.65A.41.41,0,0,1,287.25,394.67Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 286.249px 391.798px;" id="elanbmvd0msmg"
                            class="animable"></path>
                        <path
                            d="M291.18,393.63a.48.48,0,0,1-.45-.29l-1.93-4.15a.49.49,0,0,1,.24-.66.5.5,0,0,1,.67.24l1.93,4.15a.49.49,0,0,1-.46.71Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 290.222px 391.056px;" id="el6hldq3jwx49"
                            class="animable"></path>
                        <g id="elrbvohvdx2zi">
                            <rect x="267" y="47.35" width="14" height="14"
                                style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 274px 54.35px; transform: rotate(-45deg);"
                                class="animable"></rect>
                        </g>
                        <g id="eliprtyeixsmp">
                            <rect x="439.1" y="156.35" width="14" height="14"
                                style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 446.1px 163.35px; transform: rotate(-45deg);"
                                class="animable"></rect>
                        </g>
                        <g id="eld7o5it9ns7d">
                            <rect x="136.1" y="396.35" width="14" height="14"
                                style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 143.1px 403.35px; transform: rotate(-45deg);"
                                class="animable"></rect>
                        </g>
                        <g id="els6fku640xja">
                            <rect x="251.78" y="64.18" width="7.64" height="7.64"
                                style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 255.6px 68px; transform: rotate(-45deg);"
                                class="animable"></rect>
                        </g>
                        <g id="elxj6i9m9eree">
                            <rect x="246.78" y="327.18" width="7.64" height="7.64"
                                style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 250.6px 331px; transform: rotate(-45deg);"
                                class="animable"></rect>
                        </g>
                        <circle cx="200" cy="375" r="4"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 200px 375px;"
                            id="elzvn500qyuuj" class="animable"></circle>
                        <circle cx="328" cy="331" r="4"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 328px 331px;"
                            id="elh8gy1kww857" class="animable"></circle>
                        <circle cx="439" cy="89" r="4"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 439px 89px;"
                            id="elpm37hqv8s5n" class="animable"></circle>
                        <circle cx="23" cy="101.35" r="4"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 23px 101.35px;"
                            id="el283mcuipidv" class="animable"></circle>
                    </g>
                    <g id="freepik--Screens--inject-2" class="animable" style="transform-origin: 205.61px 192px;">
                        <polygon
                            points="144.34 78.35 135.59 63.56 55.06 58.26 55.06 73.12 55.06 78.47 55.06 325.74 350.08 306.31 350.08 90.39 144.34 78.35"
                            style="fill: rgb(38, 50, 56); transform-origin: 202.57px 192px;" id="eleutqbzgtlq"
                            class="animable"></polygon>
                        <polygon points="348.42 301.82 57.62 320.19 57.62 80.08 348.42 96.12 348.42 301.82"
                            style="fill: rgb(229, 229, 229); transform-origin: 203.02px 200.135px;" id="elot98nyyq5xh"
                            class="animable"></polygon>
                        <g style="clip-path: url(&quot;#freepik--clip-path--inject-2&quot;); transform-origin: 202.955px 190.215px;"
                            id="el0ic2ddjlnkx4" class="animable">
                            <g id="elbv0wdiq5e">
                                <polygon points="349.64 303.3 343.85 303.67 343.85 94.1 349.64 94.43 349.64 303.3"
                                    style="opacity: 0.17; transform-origin: 346.745px 198.885px;" class="animable">
                                </polygon>
                            </g>
                            <g id="elko7re7n040j">
                                <polygon points="349.64 301.6 343.85 301.96 343.85 220.81 349.64 220.71 349.64 301.6"
                                    style="opacity: 0.17; transform-origin: 346.745px 261.335px;" class="animable">
                                </polygon>
                            </g>
                            <polygon points="348.75 104.55 56.27 89.83 56.27 76.76 348.75 93.36 348.75 104.55"
                                style="fill: rgb(0, 105, 217); stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 202.51px 90.655px;"
                                id="el9c5ivaegpit" class="animable"></polygon>
                        </g>
                        <polygon points="348.42 301.82 57.62 320.19 57.62 80.08 348.42 96.12 348.42 301.82"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 203.02px 200.135px;"
                            id="elit7hcymlbg7" class="animable"></polygon>
                        <g id="el1n854r3h5f3">
                            <polygon
                                points="334 133.64 288.63 131.92 288.58 131.92 240.81 130.11 240.76 130.1 190.4 128.2 190.34 128.19 137.18 126.18 137.12 126.18 80.89 124.05 80.89 142.44 80.89 142.44 80.89 311.03 333.89 297.16 333.89 149.72 334 149.72 334 133.64"
                                style="opacity: 0.2; transform-origin: 207.445px 217.54px;" class="animable"></polygon>
                        </g>
                        <polygon points="157.66 137.75 100.99 136.19 100.99 117.72 157.66 119.79 157.66 137.75"
                            style="fill: rgb(0, 105, 217); stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 129.325px 127.735px;"
                            id="el5j3qd8gf6yg" class="animable"></polygon>
                        <polygon points="141.53 129.96 117.79 129.22 117.79 125.77 141.53 126.55 141.53 129.96"
                            style="fill: rgb(122, 122, 122); transform-origin: 129.66px 127.865px;" id="el7gelk0trum"
                            class="animable"></polygon>
                        <polygon points="211.32 139.22 157.72 137.75 157.72 119.8 211.32 121.75 211.32 139.22"
                            style="fill: rgb(0, 105, 217); stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 184.52px 129.51px;"
                            id="el15hp2iqm3gw" class="animable"></polygon>
                        <polygon points="262.15 140.61 211.38 139.22 211.38 121.75 262.15 123.6 262.15 140.61"
                            style="fill: rgb(0, 105, 217); stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 236.765px 131.18px;"
                            id="eli8rhk269rbp" class="animable"></polygon>
                        <polygon
                            points="310.36 141.93 310.36 125.36 262.2 123.61 262.2 140.61 100.99 136.19 100.99 305.45 356.06 291.24 356.06 143.19 310.36 141.93"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 228.525px 214.53px;"
                            id="elrhmh0qga1w" class="animable"></polygon>
                        <polygon points="356.16 143.19 310.42 141.93 310.42 125.36 356.16 127.03 356.16 143.19"
                            style="fill: rgb(0, 105, 217); stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 333.29px 134.275px;"
                            id="elhxwg6hnx3sk" class="animable"></polygon>
                        <polygon points="348.95 275.65 219.74 281.7 219.74 170.83 348.95 172.26 348.95 275.65"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 284.345px 226.265px;"
                            id="elyyykien4qj" class="animable"></polygon>
                        <polygon points="287.13 172 255.04 171.66 255.04 184.9 287.13 185.02 287.13 172"
                            style="fill: rgb(0, 105, 217); transform-origin: 271.085px 178.34px;" id="elu3pqk65r1w"
                            class="animable"></polygon>
                        <line x1="329.32" y1="200.49" x2="339.18" y2="200.44"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 334.25px 200.465px;"
                            id="elfdiaj4yip89" class="animable"></line>
                        <line x1="270.7" y1="200.76" x2="323.32" y2="200.52"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 297.01px 200.64px;"
                            id="el2cn0njsz4yr" class="animable"></line>
                        <line x1="227.94" y1="200.96" x2="264.95" y2="200.79"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 246.445px 200.875px;"
                            id="elnhyljb53e5" class="animable"></line>
                        <line x1="297.08" y1="207.59" x2="339.18" y2="207.24"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 318.13px 207.415px;"
                            id="elu8frvjx7i5r" class="animable"></line>
                        <line x1="273.24" y1="207.79" x2="290.24" y2="207.65"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 281.74px 207.72px;"
                            id="elgjf7y85gh5j" class="animable"></line>
                        <line x1="227.94" y1="208.18" x2="265.59" y2="207.86"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 246.765px 208.02px;"
                            id="elktyz3i9lu7" class="animable"></line>
                        <line x1="252.69" y1="215.09" x2="339.18" y2="214.03"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 295.935px 214.56px;"
                            id="elsnh2yv2gv4" class="animable"></line>
                        <line x1="227.94" y1="215.39" x2="244.21" y2="215.19"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 236.075px 215.29px;"
                            id="elwt1t48a9tk" class="animable"></line>
                        <line x1="318.5" y1="221.16" x2="339.18" y2="220.82"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 328.84px 220.99px;"
                            id="eloenenrf0xj" class="animable"></line>
                        <line x1="277.68" y1="221.81" x2="311.21" y2="221.27"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 294.445px 221.54px;"
                            id="el22m7q7l8y3ti" class="animable"></line>
                        <line x1="227.94" y1="222.61" x2="270.7" y2="221.92"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 249.32px 222.265px;"
                            id="ely5y0wqv39sh" class="animable"></line>
                        <line x1="265.59" y1="229.08" x2="339.18" y2="227.62"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 302.385px 228.35px;"
                            id="ellhgc9agrcig" class="animable"></line>
                        <line x1="227.94" y1="229.82" x2="258.51" y2="229.22"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 243.225px 229.52px;"
                            id="el7gi5crgik4v" class="animable"></line>
                        <line x1="329.32" y1="234.35" x2="339.18" y2="234.12"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 334.25px 234.235px;"
                            id="elsexjxh49ir9" class="animable"></line>
                        <line x1="270.7" y1="235.72" x2="323.32" y2="234.49"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 297.01px 235.105px;"
                            id="eln7fe8laa6j" class="animable"></line>
                        <line x1="227.94" y1="236.72" x2="264.95" y2="235.86"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 246.445px 236.29px;"
                            id="elrbyn0r3zarj" class="animable"></line>
                        <line x1="297.08" y1="242.06" x2="339.18" y2="240.91"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 318.13px 241.485px;"
                            id="eli4nq6vzmoi8" class="animable"></line>
                        <line x1="273.24" y1="242.7" x2="290.24" y2="242.24"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 281.74px 242.47px;"
                            id="elh8cs18l5x6s" class="animable"></line>
                        <line x1="227.94" y1="243.94" x2="265.59" y2="242.91"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 246.765px 243.425px;"
                            id="elau9g78n1zs" class="animable"></line>
                        <line x1="252.69" y1="250.39" x2="339.18" y2="247.71"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 295.935px 249.05px;"
                            id="el10awpbckxpgn" class="animable"></line>
                        <line x1="227.94" y1="251.15" x2="244.21" y2="250.65"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 236.075px 250.9px;"
                            id="elozirnhjiuf8" class="animable"></line>
                        <line x1="318.5" y1="255.22" x2="339.18" y2="254.5"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 328.84px 254.86px;"
                            id="el0opega3oevti" class="animable"></line>
                        <line x1="277.68" y1="256.64" x2="311.21" y2="255.47"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 294.445px 256.055px;"
                            id="elr802sdlcqir" class="animable"></line>
                        <line x1="227.94" y1="258.37" x2="270.7" y2="256.88"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 249.32px 257.625px;"
                            id="elg9ku3llkp2" class="animable"></line>
                        <line x1="265.59" y1="264.13" x2="339.18" y2="261.29"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 302.385px 262.71px;"
                            id="elldvh6hi85tb" class="animable"></line>
                        <line x1="227.94" y1="265.58" x2="258.51" y2="264.4"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 243.225px 264.99px;"
                            id="elbilbrm5qx7q" class="animable"></line>
                        <line x1="223.56" y1="185.15" x2="347.84" y2="185.59"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 285.7px 185.37px;"
                            id="eldpui02ro0f" class="animable"></line>
                        <line x1="255.04" y1="171.66" x2="255.04" y2="184.9"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 255.04px 178.28px;"
                            id="eloc1s9pamn9b" class="animable"></line>
                        <line x1="287.13" y1="172.01" x2="287.13" y2="185.02"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 287.13px 178.515px;"
                            id="elkk7q9ltmgb" class="animable"></line>
                        <line x1="318.15" y1="172.34" x2="318.15" y2="185.14"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 318.15px 178.74px;"
                            id="elwdm9l50ukm" class="animable"></line>
                        <polygon points="281.91 179.71 261.41 179.57 261.41 176.36 281.91 176.53 281.91 179.71"
                            style="fill: rgb(38, 50, 56); transform-origin: 271.66px 178.035px;" id="el6mqh1cjvslq"
                            class="animable"></polygon>
                        <polygon points="248.62 179.49 227.38 179.35 227.38 176.08 248.62 176.26 248.62 179.49"
                            style="fill: rgb(204, 204, 204); transform-origin: 238px 177.785px;" id="el3nf0244b0w9"
                            class="animable"></polygon>
                        <polygon points="313.42 179.92 293.61 179.79 293.61 176.63 313.42 176.8 313.42 179.92"
                            style="fill: rgb(204, 204, 204); transform-origin: 303.515px 178.275px;" id="elb789b1kxyjs"
                            class="animable"></polygon>
                        <polygon points="342.95 180.12 323.79 179.99 323.79 176.88 342.95 177.04 342.95 180.12"
                            style="fill: rgb(204, 204, 204); transform-origin: 333.37px 178.5px;" id="elfrw9xv0lszm"
                            class="animable"></polygon>
                        <polygon points="210.46 282.13 111.89 286.74 111.89 150.41 210.46 152.43 210.46 282.13"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 161.175px 218.575px;"
                            id="elb5f3urj8ayr" class="animable"></polygon>
                        <polygon
                            points="210.46 202.03 185.98 186.26 163.77 235.44 141.78 218.09 111.89 286.74 210.46 282.13 210.46 202.03"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 161.175px 236.5px;"
                            id="elwn13xzrrio" class="animable"></polygon>
                        <path
                            d="M149.17,179.49a15,15,0,0,0-14.82-15,14.8,14.8,0,0,0-15,14.82,15,15,0,0,0,15,15A14.82,14.82,0,0,0,149.17,179.49Z"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-miterlimit: 10; transform-origin: 134.26px 179.399px;"
                            id="eljaxpn72rchn" class="animable"></path>
                        <polygon points="195.64 131.65 173.18 130.95 173.18 127.58 195.64 128.32 195.64 131.65"
                            style="fill: rgb(122, 122, 122); transform-origin: 184.41px 129.615px;" id="eliilld5a6wsp"
                            class="animable"></polygon>
                        <polygon points="247.21 133.25 225.93 132.59 225.93 129.31 247.21 130.01 247.21 133.25"
                            style="fill: rgb(122, 122, 122); transform-origin: 236.57px 131.28px;" id="el35oneci9suv"
                            class="animable"></polygon>
                        <polygon points="297 134.8 276.83 134.17 276.83 130.99 297 131.65 297 134.8"
                            style="fill: rgb(122, 122, 122); transform-origin: 286.915px 132.895px;" id="elbpuj6kj939h"
                            class="animable"></polygon>
                        <polygon points="343.38 136.24 324.23 135.64 324.23 132.54 343.38 133.17 343.38 136.24"
                            style="fill: rgb(122, 122, 122); transform-origin: 333.805px 134.39px;" id="el3z8ondy7u8w"
                            class="animable"></polygon>
                    </g>
                    <g id="freepik--Character--inject-2" class="animable" style="transform-origin: 378.284px 299.333px;">
                        <ellipse cx="396.75" cy="458.45" rx="58.25" ry="8.45"
                            style="fill: rgb(0, 105, 217); transform-origin: 396.75px 458.45px;" id="elibwdr5fos9"
                            class="animable"></ellipse>
                        <g id="el950pwtzx0mh">
                            <ellipse cx="396.75" cy="458.45" rx="58.25" ry="8.45"
                                style="fill: rgb(255, 255, 255); opacity: 0.5; transform-origin: 396.75px 458.45px;"
                                class="animable"></ellipse>
                        </g>
                        <path
                            d="M367.15,141s-3.21,11.93-2.53,13.07,2.3.69,1.38,3-3,6.65-2.52,8.48,3,3.21,3,3.21,1.15,8.26,2.29,9.86,7.34.69,7.34.69l.46,6.2,18.35-1.15-.69-11-.92-34Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 379.165px 162.435px;"
                            id="el22bhldjve6u" class="animable"></path>
                        <path
                            d="M389.17,131.86c-1.14.17-9.87,0-16.75,1.14s-8.94,1.61-8.71,4.59-.46,4.13,2.06,5.27a10.26,10.26,0,0,0,3.44,1.15s-.69,3.21-.92,5.51,3.9,4.81,3.9,4.81-.23,3.44.23,4.59,1.61,1.38,2.3.46,1.14-5.28,1.83-3.44,3.44,15.59,5.28,17.2,10.09.69,12.38.23,6.65-10.09,8.72-15.83,1.14-15.82-1.84-20.41S392.15,131.4,389.17,131.86Z"
                            style="fill: rgb(38, 50, 56); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 383.868px 152.909px;"
                            id="el09cjxdxmhxts" class="animable"></path>
                        <path
                            d="M374.58,155.82a58.44,58.44,0,0,1,.56,6.44c0,2.52-1.68,3.92-.56,5s2,.56,2.8-1.4a16.54,16.54,0,0,0,1.12-7.28C378.22,156.66,377.94,152.46,374.58,155.82Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 376.369px 161.186px;"
                            id="eljectwulao5" class="animable"></path>
                        <path
                            d="M372.19,184.84l-5,9.17s12.61-3.67,19.49-3.67a94.09,94.09,0,0,1,14.45,1.38l-3.21-8.95S380.45,180.94,372.19,184.84Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 384.16px 188.176px;"
                            id="el51mw4wc94fc" class="animable"></path>
                        <path
                            d="M419.67,305.79s0,8-.69,11.47-5.27,8.71-7.11,9.63-4.13,1.15-4.59,0-1.14-.69-.45-6.65S410,302.81,410,302.81Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 413.103px 315.239px;"
                            id="elhnrokuguqi7" class="animable"></path>
                        <path d="M421.28,298.45l-1.61,7.34a17.92,17.92,0,0,1-6,.23,4.56,4.56,0,0,1-3.67-3.21l.69-6.42Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 415.64px 301.281px;"
                            id="elo3dy2qw2jh" class="animable"></path>
                        <path
                            d="M420.15,199.75s3.21,19.49,5.27,33.94,2.51,28.21,2.05,35.09-3.21,29-4.13,30.59-7.11,2.29-9.63,1.14S410,298,410,293.63s2.29-45,2.29-45Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 418.817px 250.415px;"
                            id="el33ohzwgl9cj" class="animable"></path>
                        <path
                            d="M370.6,451.57a5.61,5.61,0,0,0-2.6.66c-1.36.72-7.26,2.34-11.06,3.69-5.93,2.11-10.56,1-10.08,2.52s9.73,4.66,15.08,4.74,7.93-1.26,10.49-1.21.67,1.29,4.93,1.77,5.65.5,7.14-1.83,2.32-2.93,1.85-5.87V456a5.44,5.44,0,0,0-5.45-4.46Z"
                            style="fill: rgb(38, 50, 56); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 366.654px 457.768px;"
                            id="eldbj7q51yi47" class="animable"></path>
                        <path
                            d="M403.74,448.73a3.91,3.91,0,0,0-2.24.63c-1.16.73-6.25,2.27-9.51,3.6-5.1,2.07-9.17.69-8.7,2.37s5.94,4,10.6,4.23a38.39,38.39,0,0,0,7.56-.28c5-.28,1.83,1.5,3.64,2.24a12.17,12.17,0,0,0,3.92.56c5.32.28,6,.7,7.19-1.75s1.92-3.07,1.41-6.26V454c-.47-2.84-2.58-4.92-4.89-5Z"
                            style="fill: rgb(38, 50, 56); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 400.514px 455.512px;"
                            id="elfy2v6yz6wxo" class="animable"></path>
                        <path
                            d="M356.14,282.4s.92,32.11.92,42.89,2.75,59.49,6.42,77.15,5.73,42.89,5.73,45.64-.92,3.44.92,5.28,8.71,5.27,11.24,4.12,3.9-5.5,3.9-5.5,0-23.85.68-39.45-.45-36-.45-36,8.94,41.29,11.46,49.54,4.59,23.24,5.05,26.22,2.48,3.08,5,3.08c3.08,0,6.89-.4,8.26-2.69s-1.6-26.38-1.6-36-7.57-69.36-6.88-84,5-40.13,3.67-47.7a84.43,84.43,0,0,1-1.38-13.61S361.87,265.88,356.14,282.4Z"
                            style="fill: rgb(94, 94, 94); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 385.886px 364.103px;"
                            id="el9hcwuwr5sh" class="animable"></path>
                        <path
                            d="M369,192.87s-10.26,4.35-15.07,6.65a72.29,72.29,0,0,1-6.88,3s7.73,73,7.73,76.91-.23,4.13,1.15,5.28,8.49,1.67,21.11,1.44,28.43-2.82,29.58-2.82a5.92,5.92,0,0,0,4.58-2.75c1.38-2.06,8.74-79.9,9-80.81s-18.14-7.57-19.75-8S389.62,185.07,369,192.87Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 383.626px 237.592px;"
                            id="elsv7u94o3smd" class="animable"></path>
                        <path d="M405,239.63c-6.56,9.44-16.92,23.17-25,28.37"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 392.5px 253.815px;"
                            id="el4zg018pvwmr" class="animable"></path>
                        <path d="M411.4,230s-1.19,1.91-3.18,4.89"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 409.81px 232.445px;"
                            id="eleg4zeohu94n" class="animable"></path>
                        <path d="M392.41,262.63s-9.08,8.26-16.51,12.39"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 384.155px 268.825px;"
                            id="elkys28ukoeg" class="animable"></path>
                        <path
                            d="M405.22,412.3a29.87,29.87,0,0,0,8.52,6.24c0-.67,0-1.3,0-1.88,0-9.63-7.57-69.36-6.88-84,.12-2.67.37-5.7.68-8.91a11.69,11.69,0,0,0-.91-1.87,163.08,163.08,0,0,1-10.09-18.11l11.91,11.39c.1-.86.2-1.73.29-2.59-3.17-5.7-7.34-13.52-7.62-15.91l-14,7.56s-1.83,54.45-1.6,72.34c0,0,1.35,6.25,3.15,14.36C393,400.74,400.73,407.65,405.22,412.3Z"
                            style="fill: rgb(38, 50, 56); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 399.62px 357.6px;"
                            id="elgnri72w0h3k" class="animable"></path>
                        <path d="M358.9,286a55.36,55.36,0,0,0,3,8.32,9.72,9.72,0,0,0,4.13,4.36"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 362.465px 292.34px;"
                            id="el8v28r60arlb" class="animable"></path>
                        <path d="M373.69,444.62a54.86,54.86,0,0,1-.12,10.57"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 373.729px 449.905px;"
                            id="elpn9ld3y2uj" class="animable"></path>
                        <path d="M372.67,431.48c.21,3,.4,5.74.57,7.93"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 372.955px 435.445px;"
                            id="elxggqvo050e" class="animable"></path>
                        <path d="M366.73,312.2c.57,23,1.94,73.48,3.17,84.73.89,8.16,1.71,19.43,2.38,29"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 369.505px 369.065px;"
                            id="eldx1kmuedf2t" class="animable"></path>
                        <path d="M365.92,286.35c-.23.69.54,14.39.54,14.39s.05,2.33.15,6.26"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 366.244px 296.675px;"
                            id="elqe553b5gkcc" class="animable"></path>
                        <path
                            d="M318,220.14s.89-1.55,2.21-4.2,1.11-6,1.11-7.73,2-2.43,2-4.42-2.87-1.76-4.41-.44-2,5.3-2,5.3-2.45-4.14-3.75-7.06c-1.18-2.63-2.8-7.16-5-7.82s-2.1,2.07-1.87,2.73a26,26,0,0,0,1.36,3.75c.51,1,1.54,4,1.54,4s-3.09-2.43-4.19-2.43a1.62,1.62,0,0,0-1.33,2.43s-2.65,1.1-2,2.87.89,2.43.89,2.43-.67.88,0,3.09,3.53,6,4.63,7.73a9.59,9.59,0,0,0,2.43,2.65Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 312.444px 208.344px;"
                            id="el0nc6acf3rnic" class="animable"></path>
                        <path d="M303.68,204.24a18,18,0,0,0,2.45,3"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 304.905px 205.74px;"
                            id="elehqiltip4s8" class="animable"></path>
                        <path d="M302.58,209.54a10,10,0,0,0,1.5,2"
                            style="fill: none; stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 303.33px 210.54px;"
                            id="elfmhp0pgr32g" class="animable"></path>
                        <path
                            d="M311.18,231.63l-3.9-8.49a9.88,9.88,0,0,1,6.66-4.13c4.81-.92,5.5,0,5.5,0l2.52,8.72S313.71,228.42,311.18,231.63Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 314.62px 225.116px;"
                            id="elxej1y7y39v" class="animable"></path>
                        <path
                            d="M334.58,247.22s-7.11-12.15-8.95-16.51-4.35-5.51-8.48-5.05-7.8,4.82-7.8,8,14.68,34.86,15.37,36.7,5.73,2.29,9.17.23S337.79,257.32,334.58,247.22Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 323.049px 248.757px;"
                            id="elffmqdajy8dh" class="animable"></path>
                        <path
                            d="M347,202.5s-9.46,27.89-11.06,32.24-9,24.18-11,28.08-.22,10.55,6,11.47,7.11-.92,10.32-5.51,11.13-16.06,11.13-16.06S348.86,207.77,347,202.5Z"
                            style="fill: rgb(255, 255, 255); stroke: rgb(38, 50, 56); stroke-linecap: round; stroke-linejoin: round; transform-origin: 338.274px 238.51px;"
                            id="elka2bd9rdg" class="animable"></path>
                    </g>
                    <defs>
                        <filter id="active" height="200%">
                            <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2">
                            </feMorphology>
                            <feFlood flood-color="#32DFEC" flood-opacity="1" result="PINK"></feFlood>
                            <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>
                            <feMerge>
                                <feMergeNode in="OUTLINE"></feMergeNode>
                                <feMergeNode in="SourceGraphic"></feMergeNode>
                            </feMerge>
                        </filter>
                        <filter id="hover" height="200%">
                            <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2">
                            </feMorphology>
                            <feFlood flood-color="#ff0000" flood-opacity="0.5" result="PINK"></feFlood>
                            <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>
                            <feMerge>
                                <feMergeNode in="OUTLINE"></feMergeNode>
                                <feMergeNode in="SourceGraphic"></feMergeNode>
                            </feMerge>
                            <feColorMatrix type="matrix"
                                values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 ">
                            </feColorMatrix>
                        </filter>
                    </defs>
                    <defs>
                        <clipPath id="freepik--clip-path--inject-2">
                            <polygon points="348.42 301.82 57.62 320.19 57.62 80.08 348.42 96.12 348.42 301.82"
                                style="fill:#e5e5e5;stroke:#263238;stroke-linecap:round;stroke-linejoin:round"></polygon>
                        </clipPath>
                    </defs>
                </svg>
                <p class="font-italic text-muted mb-0">Sistem Manajemen Pengawasan Inspektorat Utama</p>
                <p class="font-italic text-muted">Digitalkan proses pengawasan Inspektorat Utama</p>
            </div>
            <div class="col-md-7 col-lg-6 ml-auto">
                <div class="form-group col-lg-12 mx-auto">
                    {{-- <h1 class="mb-3 text-primary">Login ke SIMWAS</h1> --}}
                    <a class="btn btn-primary btn-block py-2 btn-facebook" href="/auth/google">
                        <span class="fab fa-google"></span> Sign in dengan Google
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
