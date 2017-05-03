var PublicBlogs = React.createClass({
    getInitialState: function () {
        return {data: []};
    },
    loadBlogs: function () {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            success: function (data) {
                this.setState({data: data});
            }.bind(this),
            error: function (xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    componentDidMount: function () {
        this.loadBlogs();
        setInterval(this.loadBlogs, this.props.pollInterval);
    },
    render: function () {
        return (
            <div className="mhPublicBlogs">
                <h1>Visita los blogs del colegio</h1>
                <PublicBlogsList data={this.state.data}/>
            </div>
        )
    }
});
