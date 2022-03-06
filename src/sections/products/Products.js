import React from "react";

// nutny import pre pouzivanie slidera - https://github.com/akiran/react-slick
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

import { Product } from './Product';
import { Heading } from "../../components/texts/Heading";
import { JumpToLink } from "../../components/links/JumpToLink";
import '../../css/products.css';

import biele_2020 from '../../images/products/biele_2020.jpg';
import cervene_2020 from '../../images/products/cervene_2020.jpg';

export class Products extends React.Component {

    render() {
        var sliderSettings = {
            dots: true,
            infinite: false,
            speed: 1500,
            slidesToShow: 2,
            slidesToScroll: 1,
            className: 'product-slider',
            // variableWidth: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }
            ]
        };

        return (
            <div id="products">
                <div className="container section" data-href="#products" data-nav-title="Ponuka">
                    <Heading title="Naša aktuálna ponuka" />
                    <div id="productList">
                        <Slider {...sliderSettings}>
                            <Product
                                title="Biele domáce vínko"
                                subtitle="ročník 2020"
                                price="3€/l"
                                photo={biele_2020}
                            />
                            <Product
                                title="Červené domáce vínko"
                                subtitle="ročník 2020"
                                price="3€/l"
                                photo={cervene_2020}
                            />
                        </Slider>
                    </div>
                    <JumpToLink link="#contact" />                
               </div>
            </div>
        )
    }
}