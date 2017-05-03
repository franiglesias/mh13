var Blog = React.createClass({
    render: function () {
        return (
            <div className="column" key="{this.props.id}">
                <a href={"/blog/" + this.props.slug}>
                    <div className="media-object button">
                        {
                            undefined != this.props.icon &&
                            <div className="media-object-section align-self-center">
                                <img src={this.props.icon} alt={this.props.title} width="32"/>
                            </div>
                        }
                        <div className="media-object-section main-section text-left">{this.props.title}</div>
                    </div>
                </a>
            </div>
        )
    }
});

