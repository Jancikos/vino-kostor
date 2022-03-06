import React from "react";

import * as fa from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

export function JumpToLink(props) {
    return (
        <a className="link-more" href={props.link}>
        <FontAwesomeIcon icon={fa.faChevronDown} size="2x" />
        </a>
    );
}