<!doctype html>
<html lang="en" dir="ltr" class="scroll-smooth focus:scroll-auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Meta Tags -->
    <meta name="description" content="This is a page about top memu.">
    <meta name="keywords" content="hexadash, web development, UI components">
    <meta name="author" content="dashboardmarket.com">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= assetsPath ?>/images/logos/icon.png">
    <!-- Title -->
    <title>Professeur</title>

    <!-- inject:css-->
    <link rel="stylesheet" href="<?= assetsPath ?>/vendor_assets/css/apexcharts.min.css">
    <link rel="stylesheet" href="<?= assetsPath ?>/vendor_assets/css/datepicker.min.css">
    <link rel="stylesheet" href="<?= assetsPath ?>/vendor_assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= assetsPath ?>/vendor_assets/css/nouislider.min.css">
    <link rel="stylesheet" href="<?= assetsPath ?>/vendor_assets/css/quill.snow.css">
    <link rel="stylesheet" href="<?= assetsPath ?>/vendor_assets/css/svgMap.min.css">
    <link rel="stylesheet" href="<?= assetsPath ?>/css/styles.css">
    <!-- endinject -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css">
    <style>
        /* Custom CSS to style the date input */
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0; /* Hide the native icon */
            cursor: pointer;
        }
        .custom-date-input {
            position: relative;
        }
        .custom-date-input::before {
            content: '\1F4C5'; /* Unicode character for calendar icon */
            position: absolute;
            top: 70%;
            right: 15px;
            transform: translateY(-50%);
            color: #4A90E2; /* Change the color here */
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-main-dark font-jost relative text-[15px] font-normal leading-[1.5] m-0 p-0">

<!-- Aside -->

<aside id="asideBar" class="asidebar bg-box-dark fixed start-0 top-0 z-[1035] h-screen overflow-hidden xl:!w-[280px] xl:[&.collapsed]:!w-[80px] [&.collapsed]:!w-[250px] xl:[&.TopCollapsed]:!w-[0px] [&.TopCollapsed]:!w-[250px] !transition-all !duration-[0.2s] ease-linear delay-[0s] !w-0 xl:[&.collapsed>.logo-wrapper]:w-[80px]">
    <div class="flex w-[280px] border-e border-box-dark-up logo-wrapper items-center h-[71px] bg-box-dark-up max-xl:hidden">
        <a href="/prof/1/cours" class="block text-center">
            <div class="logo-full">
                <img class="ps-[27px] block" src="<?= assetsPath ?>/images/logos/logo-edu-removebg.png" alt="Logo">
            </div>
            <div class="hidden logo-fold">
                <img class="p-[27px] max-w-[80px]" src="<?= assetsPath ?>/images/logos/logo-fold.png" alt="Logo">
            </div>
        </a>
    </div>
    <nav id="navBar" class="navBar bg-box-dark start-0 max-xl:top-[80px] z-[1035] h-full overflow-y-auto xl:!w-[280px] xl:[&.collapsed]:!w-[80px] [&.collapsed]:!w-[250px] xl:[&.TopCollapsed]:!w-[0px] [&.TopCollapsed]:!w-[250px] !transition-all !duration-[0.2s] ease-linear delay-[0s] !w-0 pb-[100px] scrollbar xl:[&.collapsed]:ps-[7px] relative">
        <ul class="relative m-0 list-none px-[0.2rem] ">
            <li class="relative sub-item-wrapper group ">
                <a class="group-[.open]:bg-primary/10 rounded-e-[20px] text-subtitle-dark flex h-12 cursor-pointer items-center gap-[16px] truncate px-6 py-4 text-[14px] font-medium outline-none transition duration-300 ease-linear hover:text-title-dark hover:outline-none focus:text-title-dark focus:outline-none active:text-title-dark active:outline-none [&.active]:text-title-dark motion-reduce:transition-none hover:bg-box-dark-up focus:bg-box-dark-up active:bg-box-dark-up group capitalize ">
                  <span class="nav-icon text-subtitle-dark text-[18px] group-hover:text-current group-[&.active]:text-current group-focus:text-current">
                     <i class="uil uil-apps"></i>
                  </span>
                    <span class="capitalize title">Mes cours</span>
                    <span class=" arrow-down text-subtitle-dark absolute end-0 me-[0.8rem] ms-auto text-[18px] transition-transform duration-300 ease-linear motion-reduce:transition-none group-hover:text-current">
                     <i class="uil uil-angle-down"></i>
                  </span>
                </a>
                <ul class="sub-item !visible m-0 hidden list-none p-0 [&.show]:block scrollbar overflow-y-scroll ">
                    <li class="relative border-box-dark-up">
                        <a href="/prof/1/cours" class="capitalize rounded-e-[20px] text-gray-600 hover:text-title-dark focus:text-inherit active:text-inherit [&.active]:text-title-dark text-subtitle-dark flex cursor-pointer items-center truncate py-[10px] pe-6 ps-[60px] text-[14px] outline-none transition duration-300 ease-linear hover:outline-none focus:outline-none active:outline-none motion-reduce:transition-none hover:bg-box-dark-up focus:bg-box-dark-up active:bg-box-dark-up ">
                            <span>Liste</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

<!-- End: Aside -->

<!-- Wrapping Content -->
<div class="relative flex flex-col flex-1 xl:ps-[280px] xl:[&.expanded]:ps-[80px] xl:[&.TopExpanded]:ps-[0px] !transition-all !duration-[0.2s] ease-linear delay-[0s] bg-main-dark" id="content">
    <!-- Header -->
    <header class="sticky top-0 flex w-full xl:z-[999] max-xl:z-[9999] bg-box-dark drop-shadow-none min-h-[70px]">
        <!-- Navigation -->
        <div class="flex flex-1 nav-wrap md:ps-[20px] ps-[30px] pe-[30px] max-xs:ps-[15px] max-xs:pe-[15px] bg-box-dark">
            <!-- Header left menu -->

            <ul class="flex items-center mb-0 list-none nav-left ps-0 gap-x-[14px] gap-y-[9px]">
                <!-- Navigation Items -->
                <li class="xl:hidden xl:[&.flex]:flex" id="topMenu-logo">
                    <div class="flex md:w-[190px] xs:w-[170px] max-xs:w-[100px] max-md:pe-[30px] max-xs:pe-[15px] border-e border-box-dark-up logo-wrapper items-center h-[71px] bg-box-dark-up">
                        <a href="/prof/1/cours" class="block text-center">
                            <div class="logo-full">
                                <img class="md:ps-[15px] block" src="<?= assetsPath ?>/images/logos/logo-edu-removebg.png" alt="Logo">
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <a class="flex items-center justify-center sm:min-w-[40px] sm:w-[40px] sm:h-[40px] min-w-[34px] h-[34px] rounded-full bg-transparent hover:text-title-dark hover:bg-box-dark-up group transition duration-200 ease-in-out text-subtitle-dark max-md:hover:bg-box-dark-up sm:text-[20px] text-[19px] cursor-pointer xl:[&.hide]:hidden max-md:bg-box-dark-up max-md:hover:text-subtitle-dark" id="slim-toggler">
                        <i class="uil uil-align-center-alt text-current [&.is-folded]:hidden flex items-center"></i>
                    </a>
                </li>
            </ul>

            <!-- Header right menu -->

            <div class="flex items-center ms-auto py-[15px] sm:gap-x-[25px] max-sm:gap-x-[15px] gap-y-[15px] relative">

                <button type="button" class="flex xl:hidden items-center text-[22px] text-subtitle-dark min-h-[40px]" id="author-dropdown">
                    <i class="uil uil-ellipsis-v text-[18px]"></i>
                </button>

                <ul id="right-ellipsis-trigger" class="xl:flex hidden items-center justify-end flex-auto mb-0 list-none ps-0 sm:gap-x-[25px] max-sm:gap-x-[15px] gap-y-[15px] max-xl:absolute max-xl:z-[1000] max-xl:m-0 max-xl:rounded-lg max-xl:border-none max-xl:bg-clip-padding max-xl:text-left max-xl:shadow-lg max-xl:bg-neutral-700 max-xl:[&.active]:flex max-xl:end-0 max-xl:px-[20px] max-sm:px-[15px] max-xl:py-[10px] max-xl:top-[70px]">
                    <li>
                        <div class="relative" data-te-dropdown-ref>
                            <button type="button" id="author-dropdown" data-te-dropdown-toggle-ref aria-expanded="false" class="flex items-center me-1.5 text-subtitle-dark text-sm font-medium capitalize rounded-full md:me-0 group whitespace-nowrap">
                                <span class="sr-only">Ouvrir le menu utilisateur</span>
                                <img class="min-w-[32px] w-8 h-8 rounded-full xl:me-2" src="images/avatars/thumbs.png" alt="user photo">
                                <span class="hidden xl:block"><?= $user->prenom." ".$user->nom ?></span>
                                <i class="uil uil-angle-down text-subtitle-dark text-[18px] hidden xl:block"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div class="absolute z-[1000] ltr:float-left rtl:float-right m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-clip-padding text-left text-base shadow-boxLargeDark bg-box-dark-down  [&[data-te-dropdown-show]]:block" aria-labelledby="author-dropdown" data-te-dropdown-menu-ref>
                                <div class="min-w-[310px] max-sm:min-w-full pt-4 px-[15px] py-[12px] bg-box-dark shadow-[0_5px_30px_rgba(1,4,19,.60)] rounded-4">
                                    <figure class="flex items-center text-sm rounded-[8px] bg-box-dark-up py-[20px] px-[25px] mb-[12px] gap-[15px]">
                                        <img class="w-8 h-8 rounded-full bg-regular" src="images/avatars/thumbs.png" alt="user">
                                        <figcaption>
                                            <div class="text-title-dark mb-0.5 text-sm"><?= $user->prenom." ".$user->nom ?></div>
                                            <div class="mb-0 text-xs text-subtitle-dark"><?= $user->role?></div>
                                        </figcaption>
                                    </figure>
<!--                                    <ul class="m-0 pb-[10px] overflow-x-hidden overflow-y-auto scrollbar bg-transparent max-h-[230px]">-->
<!---->
<!--                                        <li class="w-full">-->
<!--                                            <div class="p-0 hover:text-white hover:bg-box-dark-up rounded-4">-->
<!--                                                <button class="inline-flex items-center text-subtitle-dark hover:text-primary hover:ps-6 w-full px-2.5 py-3 text-sm transition-[0.3s] gap-[10px]">-->
<!--                                                    <i class="text-[16px] uil uil-user"></i>-->
<!--                                                    Profile-->
<!--                                                </button>-->
<!--                                            </div>-->
<!--                                        </li>-->
<!--                                    </ul>-->
                                    <a  href="/logout" class="flex items-center justify-center text-sm font-medium bg-box-dark-up h-[50px] hover:text-subtitle-dark text-title-dark mx-[-15px] mb-[-15px] rounded-b-6 gap-[6px]">
                                        <i class="uil uil-sign-out-alt"></i> Sign Out</a>
                                </div>
                            </div>
                        </div>


                    </li>
                </ul>
            </div>

        </div>
        <!-- End: Navigation -->
    </header>
    <!-- End: Header -->

    <!-- Main Content -->
    <main class="bg-main-dark">
        <div class=" mx-[30px] min-h-[calc(100vh-195px)] mb-[30px] ssm:mt-[30px] mt-[15px]">
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12">

                    <!-- Breadcrumb Section -->
                    <div class="leading-[1.8571428571] flex flex-wrap sm:justify-between justify-center items-center ssm:mb-[33px] mb-[18px] max-sm:flex-col gap-x-[15px] gap-y-[5px]">
                        <!-- Title -->
                        <h4 class="capitalize text-[20px] text-title-dark font-semibold">Cours</h4>
                        <!-- Breadcrumb Navigation -->
                        <div class="flex flex-wrap justify-center">
                            <nav>
                                <ol class="flex flex-wrap p-0 mb-0 list-none gap-[8px] max-sm:justify-center">
                                    <!-- Parent Link -->
                                    <li class="inline-flex items-center">
                                        <a class="text-[14px] font-normal leading-[20px] text-neutral-200 hover:text-primary group" href="index.html">
                                            <i class="uil uil-estate text-white/50 me-[8px] text-[16px] group-hover:text-current"></i>Accueil</a>
                                    </li>
                                    <!-- Middle (Conditional) -->

                                    <li class="inline-flex items-center before:content-[''] before:w-1 before:h-1 before:ltr:float-left rtl:float-right before:bg-light-extra before:me-[7px] before:pe-0 before:rounded-[50%]">
                                        <span class="text-[14px] font-normal leading-[20px] text-neutral-200 transition duration-300 capitalize">pages</span>
                                    </li>

                                    <!-- Child (Current Page) -->
                                    <li class="inline-flex items-center before:content-[''] before:w-1 before:h-1 before:ltr:float-left rtl:float-right before:bg-light-extra before:me-[7px] before:pe-0 before:rounded-[50%]" aria-current="page">
                                        <span class="text-[14px] font-normal leading-[20px] flex items-center capitalize text-subtitle-dark">Liste</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <?= $content ?>

        </div>
        <!-- Footer -->
        <footer class="px-[25px] bg-box-dark">

            <!-- Footer content -->
            <div class="flex justify-between flex-wrap py-[22px] gap-x-[30px] gap-y-[15px] max-ssm:gap-y-[8px] items-center max-md:flex-col">
                <!-- Copyright information -->
                <div class="flex items-center gap-[4px] text-[14px] font-medium max-md:text-center text-subtitle-dark">© <span class="current-year">2022</span> <a href="#" class="text-primary">SovWare</a></div>

                <!-- Footer navigation links -->
                <div class="justify-end md:justify-center items-center flex gap-[15px]">
                    <a href="#" class="text-subtitle-dark text-[14px] hover:text-title-dark">About</a>
                    <a href="#" class="text-subtitle-dark text-[14px] hover:text-title-dark">Team</a>
                    <a href="#" class="text-subtitle-dark text-[14px] hover:text-title-dark">Contact</a>
                </div>
            </div>

        </footer>
        <!-- end: Footer -->
    </main>
    <!-- End: Main Content -->
</div>
<!-- End: Wrapping Content -->

<!-- Preloader -->

<!--<div class="preloader fixed w-full h-full z-[9999] flex items-center justify-center top-0 bg-black">-->
<!--    <div class="animate-spin inline-block w-[50px] h-[50px] border-[3px] border-current border-t-transparent text-primary rounded-full" role="status" aria-label="loading">-->
<!--        <span class="sr-only">Loading...</span>-->
<!--    </div>-->
<!--</div>-->

<!-- End: Preloader -->

<!-- inject:js-->
<script src="<?= assetsPath ?>/vendor_assets/js/apexcharts.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/datepicker-full.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/fslightbox.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/index.global.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/mixitup.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/moment.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/nouislider.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/quill.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/svg-pan-zoom.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/svgMap.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/tw-elements.umd.min.js"></script>
<script src="<?= assetsPath ?>/vendor_assets/js/yscountdown.min.js"></script>
<script src="<?= assetsPath ?>/theme_assets/js/main.js"></script>
</body>

</html>