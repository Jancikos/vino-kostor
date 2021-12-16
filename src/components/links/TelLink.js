import React from "react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import * as fa from '@fortawesome/free-solid-svg-icons'

import {Link} from './Link';

export function TelLink(props) {
    return ( 
        <Link 
            href={"tel:" + props.number.replaceAll(' ', '')}
            title={props.number}
            iconBefore={<FontAwesomeIcon icon={fa.faPhone} />}
            iconAfter={<FontAwesomeIcon icon={fa.faPhone} flip="horizontal" />}
        />
    );
}