var Article = React.createClass({
    render: function () {
        return (
            <div className="article" key="{this.props.id}">
                <h2>{this.props.title}</h2>
            </div>
        )
    }
});

