<?php

/**
 * *** DO NOT EDIT ***
 */
?>
<section class="flex items-center min-h-screen p-2 md:p-16 bg-gray-900 text-gray-100 relative z-[9999999]">

    <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">

        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" data-name="Layer 1" viewBox="0 0 48 48" class="w-32">
            <defs>
                <style>
                    .cls-1 {
                        fill: url(#linear-gradient);
                    }

                    .cls-2 {
                        fill: url(#linear-gradient-2);
                    }

                    .cls-3 {
                        fill: url(#linear-gradient-3);
                    }
                </style>

                <linearGradient id="linear-gradient" x1="12.134" y1="20.336" x2="42.027" y2="41.389" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#fed200" />
                    <stop offset="1" stop-color="#f59815" />
                </linearGradient>

                <linearGradient id="linear-gradient-2" x1="20.318" y1="15.588" x2="27.55" y2="26.115" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#3e4154" />
                    <stop offset="1" stop-color="#1b2129" />
                </linearGradient>

                <linearGradient id="linear-gradient-3" x1="21.779" y1="32.279" x2="26.076" y2="36.576" xlink:href="#linear-gradient-2" />
            </defs>

            <path class="cls-1" d="M44.5,34.5,28.33,6.5a5,5,0,0,0-8.66,0L3.5,34.5A5,5,0,0,0,7.834,42H40.166a5,5,0,0,0,4.33-7.5Z" />

            <path class="cls-2" d="M24,30A2.1,2.1,0,0,0,26.1,28.1l1.18-11.8A3,3,0,0,0,24.29,13h-.58a3,3,0,0,0-2.985,3.3L21.905,28.1A2.1,2.1,0,0,0,24,30Z" />

            <circle class="cls-3" cx="24" cy="34.5" r="3.5" />
        </svg>

        <div class="max-w-md text-center">

            <?php
            if (empty($args)) :
                $min_screen_size = '1920px';
            else :
                $min_screen_size = $args;
            endif;
            ?>

            <p class="text-2xl font-semibold md:text-3xl">Please view this page on a screen width of <?php echo $min_screen_size ?> or more.</p>

            <p class="mt-4 mb-8 dark:text-gray-400 text-md md:text-lg">This page is not currently optimized for a screen width of less than <?php echo $min_screen_size ?>. Once the website is complete, you'll be able to view this on any screen size.</p>

            <p class="mt-4 mb-8 dark:text-gray-400 text-md md:text-lg">You can use the Ctrl / Cmd and "+" or "-" keys to zoom out and view this page on a smaller screen.</p>

        </div>

    </div>

</section>