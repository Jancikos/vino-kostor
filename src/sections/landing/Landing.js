import React from "react";
import * as fa from '@fortawesome/free-solid-svg-icons'

import { Heading } from "../../components/texts/Heading";
import '../../css/landing.css';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

export class Landing extends React.Component {

    render() {
        return (
            <div id="landing">
                <a id="more" href="#aboutSection">
                    <FontAwesomeIcon icon={fa.faChevronDown} size="2x" />
                </a>
            </div>
        )
    }
}