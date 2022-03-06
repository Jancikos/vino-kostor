import React from "react";

import { Heading } from "../../components/texts/Heading";
import { JumpToLink } from "../../components/links/JumpToLink";
import '../../css/about.css';

import imgMy from '../../images/simonko.jpg';

export class About extends React.Component {

    render() {
        return (
            <div id="aboutSection">
                <div className="container section">
                    <h1 id="aboutHeading" className="hide">O v skratke o nás</h1>
                    <div id="about">
                        <img src={imgMy} alt="Fotka nás" />
                        <div className="about-text-wrapper">
                            <Heading title="V skratke o nás" />
                            <div className="about-text">
                                <p>
                                    Pod značku Víno Kostor sa schováva príbeh rodiny z regiónu Hont, v ktorej sa už po mnohé generácie vyrábalo domáce víno  z vlastnoručne obrábaného samorodného viniča, ktorý rastie a dozrieva na úpätí bývalého sopečného pohoria Štiavnické vrchy.
                                </p>
                                <p>
                                    Aktuálne má pri tvorbe nášho vína hlavné slovo Ľubo Kostor, ktorého pravou rukou sa stali  jeho dvaja synovania Jano a Šimon.
                                </p>
                                <p>
                                    Práve najmladšia generácia Kostorovcov popri hodinách trávených vo vinohrade prišla s nápadom  spropagovať našu tvrdú prácu a zároveň dopriať okoliu poctivé stredoslovenské vínko s cieľom naučiť slovákov na slovenské vína s príbehom.
                                </p>
                            </div>
                        </div>
                    </div>
                    <JumpToLink link="#products" />  
                </div>              
            </div>
        )
    }
}