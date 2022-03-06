import React from "react";

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faWineGlass } from '@fortawesome/free-solid-svg-icons'


import { TelLink } from '../../components/links/TelLink';
import { MapLink } from '../../components/links/MapLink';

import "../../css/header.css"

export class Header extends React.Component {
    render() {
        return (
            <div id="header">
                <div id="background" style={{opacity: this.props.opacity}}></div>
                <div className="container">
                    <a href="http://vinokostor.sk" className="logo">
                        <FontAwesomeIcon icon={faWineGlass} className="icon" />
                        <span>Víno Kostor</span>
                    </a>
                    <div id="navbar">
                        <nav id="desktop-navbar">
                            <li className="navbar-item">
                                <a href="#aboutSection">O nás</a>
                            </li>
                            <li className="navbar-item">
                                <a href="#products">Ponuka</a>
                            </li>
                            <li className="navbar-item">
                                <a href="#contact">Kontakt</a>
                            </li>
                        </nav>
                    </div>
                </div>
            </div>
        );
    }
}