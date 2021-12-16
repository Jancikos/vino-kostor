import React from "react";
import Carousel from 'nuka-carousel'; // https://github.com/FormidableLabs/nuka-carousel

import { ShowcaseItem } from './ShowcaseItem';
import "../../css/showcase.css";

export class Showcase extends React.Component {

    render() {
        return (
            <div id="showcase">
                <Carousel
                    autoplay={true}
                    autoplayInterval={5000}
                    >
                    <ShowcaseItem
                        image='pivnicaExterier'
                        title="Pivnička"
                        text="Naše vínko tvoríme aj skladujeme v pivničke, ktorá sa nachádza vo vinárskej osade Biele Dráhy pri obci Ladzany" />
                    <ShowcaseItem
                        image="pivnicaInterier"
                        title="Posedenie pri vínku"
                        text='Koštovku našej práce môžeme aj s pohostením absolovať v príjemne zariadenej miestnosti priamo pri vstupe do "hrtanu" pivnice.' />
                    <ShowcaseItem
                        image="vinica"
                        title="Vinica"
                        text='Základom našeho vínka je nášho doma pestovaný vinič.' />
                </Carousel>
            </div>
        );
    }
}