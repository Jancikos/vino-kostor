import React from "react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import * as fa from '@fortawesome/free-solid-svg-icons'

import {Link} from './Link';

export function MailLink(props) {
    return (
        <Link 
            href={"mailto:" + props.email ?? props.title}
            title={props.title}
            iconBefore={<FontAwesomeIcon icon={fa.faEnvelope  } />}
            iconAfter={<FontAwesomeIcon icon={fa.faEnvelope   } />}
        />
    );
}