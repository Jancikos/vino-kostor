import React from "react";

import {ContactPerson} from './ContactPerson';

import '../../css/contact.css';

import imgLubko from '..//../images/lubko.jpg';
import imgJanko from '..//../images/janko.jpg';
import imgSimon from '..//../images/simonko.jpg';
import { Heading } from "../../components/texts/Heading";

export class Contact extends React.Component {

    render(){
        return(
            <div className="container section">
                <div id="contact">
                    <Heading title="S radosťou nás kontaktujte" />
                    <div id="contactPeople">
                        <ContactPerson 
                            name="Ľubo Kostor"
                            subtitle="hlavný vincúr"
                            motto=""
                            phone="0903 548 162"                        
                            photo={imgLubko}
                            />
                        <ContactPerson 
                            name="Janko Kostor"
                            subtitle="vicevincúr"
                            motto=""
                            email="janko@vinokostor.sk"
                            phone="0902 200 593"                        
                            photo={imgJanko}
                            />
                        {/* <ContactPerson 
                            name="Šimonko Kostor"
                            subtitle="vicevincúr vo výčbe"
                            email="simon@vinokostor.sk"
                            photo={imgSimon}
                            /> */}
                    </div>
                </div>
            </div>
        )
    }
}