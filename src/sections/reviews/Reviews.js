import React from "react";

import { Heading } from "../../components/texts/Heading";

import '../../css/reviews.css';

export class Reviews extends React.Component {
    constructor(props){
        super(props);

        this.state = {
            error: null,
            isLoaded: false,
            reviews: [],
        }
    }

    componentDidMount() {
        fetch("")
        .then(res => res.json())
        .then((data) => {
            console.log(data);
        });
    }


    render() {
        const { error, isLoaded, reviews } = this.state;
        if (error) {
          return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
          return <div>Loading...</div>;
        } else {
          return (
            <ul>
              {reviews.map(item => (
                <li key={item.id}>
                  {item.name} {item.price}
                </li>
              ))}
            </ul>
          );
        }
    }
}