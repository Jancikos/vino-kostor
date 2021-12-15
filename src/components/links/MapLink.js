import React from "react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import * as fa from '@fortawesome/free-solid-svg-icons'

import {Link} from './Link';

export function MapLink(props) {
    return (
        <Link 
            href={props.link}
            title={props.title}
            iconBefore={<FontAwesomeIcon icon={fa.faMap  } />}
            iconAfter={<FontAwesomeIcon icon={fa.faMap   } />}
        />
    );
}