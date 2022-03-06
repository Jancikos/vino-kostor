import React from "react";

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faWineGlass } from '@fortawesome/free-solid-svg-icons'


import { Navbar } from './Navbar';

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
                    <Navbar />
                </div>
            </div>
        );
    }
}