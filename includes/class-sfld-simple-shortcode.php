<?php

/**
 * Load Shortcode
 *
 * @package SFLD Simple Features
 * 
 */

class SFLD_Simple_Shortcode
{

    function sfld_create_shortcode_swiper() : void {

        /**
         * Create Shortcode to Display Swiper slider
         *
         */

        echo <<<END
            <style type="text/css">
                .swiper {
                    height: 300px;
                }

                .swiper-slide {
                    overflow: hidden;
                }
            </style>
            <div class="swiper mySwiper1 swiper-h">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">Horizontal Slide 1</div>
                    <div class="swiper-slide">
                        <div class="swiper mySwiper2 swiper-v">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">Vertical Slide 1</div>
                                <div class="swiper-slide">Vertical Slide 2</div>
                                <div class="swiper-slide">Vertical Slide 3</div>
                                <div class="swiper-slide">Vertical Slide 4</div>
                                <div class="swiper-slide">Vertical Slide 5</div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">Horizontal Slide 3</div>
                    <div class="swiper-slide">Horizontal Slide 4</div>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        END;
    }

}
