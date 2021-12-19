import React from "react";

import {ContactPerson} from './ContactPerson';

import '../../css/contact.css';

import imgLubko from '..//../images/lubko.jpg';
import imgJanko from '..//../images/janko.jpg';
import imgSimon from '..//../images/simonko.jpg';

export class Contact extends React.Component {

    render(){
        return(
            <div id="contact">
                <h1> S radosťou nás kontaktujte </h1>
                <div id="contactPeople">
                    <ContactPerson 
                        name="Ľubo Kostor"
                        subtitle="hlavný vincúr"
                        phone="0903 548 162"                        
                        photo={imgLubko}
                        />
                    <ContactPerson 
                        name="Janko Kostor"
                        subtitle="vicevincúr"
                        email="janko@vinokostor.sk"
                        phone="0902 200 593"                        
                        photo={imgJanko}
                        />
                    <ContactPerson 
                        name="Šimonko Kostor"
                        subtitle="vicevincúr vo výčbe"
                        email="simon@vinokostor.sk"
                        photo={imgSimon}
                        />
                </div>
            </div>
        )
    }
}