import React from "react";

import {ContactPerson} from './ContactPerson';

import '../../css/contact.css';

import imgLubko from '../../images/lubko.jpg';
import imgJanko from '../../images/janko.jpg';
import { Heading } from "../../components/texts/Heading";

export class Contact extends React.Component {

    render(){
        return(
            <div id="contact">
                <div className="container section">
                    <Heading title="S radosťou nás kontaktujte" />
                    <div id="contactPeople">
                        <ContactPerson 
                            name="Ľubo Kostor"
                            subtitle="hlavný vincúr"
                            motto="Víno a hlavne vinohrad je mojou celoživotnou záľubou."
                            phone="0903 548 162"                        
                            photo={imgLubko}
                            />
                        <ContactPerson 
                            name="Ján Kostor"
                            subtitle="vicevincúr"
                            motto="Oco ma k vinárstvu viedol od malička. No prv ako som mohol naše vínko aspoň privoňať, som si túto odmenu musel odslúžiť v našom vinohrade, z ktorého aj naše vínko pramení."
                            email="janko@vinokostor.sk"
                            phone="0902 200 593"                        
                            photo={imgJanko}
                            />
                    </div>
                </div>
            </div>
        )
    }
}