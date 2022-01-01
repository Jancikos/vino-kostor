import React from "react";

import '../../css/contact.css';

export class Map extends React.Component {
    render() {
        return (
            <div id="map">
                <iframe id="map" src="https://maps.google.com/maps?q=V%C3%ADno%20Kostor&t=k&z=17&ie=UTF8&iwloc=&output=embed" loading="lazy">
                </iframe>
            </div>
        )
    }
}