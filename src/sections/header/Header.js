import React from "react";  

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faWineGlass } from '@fortawesome/free-solid-svg-icons'


import { TelLink} from '../../components/links/TelLink';
import { MapLink} from '../../components/links/MapLink';

import "../../css/header.css"

export class Header extends React.Component{
    render(){
        return (
            <div id="header"> 
                <div className="logo">
                    <a href="http://vinokostor.sk">
                        <FontAwesomeIcon icon={faWineGlass} className="icon" />
                        <span>Víno <br/> Kostor</span>
                    </a>
                </div>
                <div id="navbar">
                    <div id="desktop-navbar">
                        <MapLink title="Ladzany 6/45" href="https://www.google.sk/maps/place/V%C3%ADno+Kostor/@48.2701849,18.9030187,17z/data=!3m1!4b1!4m5!3m4!1s0x476ac736d91aaf8b:0x2677a7da21b59c3!8m2!3d48.2701814!4d18.9052074" />
                        <TelLink number="0902 200 593" />
                    </div>
                </div>
            </div>
        );  
    }
}