var CatalogView = React.createClass({
    getInitialState: function () {
        return {data: [], page: 1};
    },
    loadArticles: function () {
        $.ajax({
            url: this.props.url + '&page=' + this.state.page,
            dataType: 'json',
            success: function (data) {
                if (data.length == 0) {
                    this.state.page = this.state.page - 1;
                    return;
                }
                this.setState({data: data});

            }.bind(this),
            error: function (xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    componentDidMount: function () {
        this.loadArticles();
        setInterval(this.loadArticles, this.props.pollInterval);
    },
    nextPage: function (event) {
        event.preventDefault();
        this.state.page = this.state.page + 1;
        this.loadArticles();
    },
    prevPage: function (event) {
        event.preventDefault();
        if (this.state.page > 1) {
            this.state.page = this.state.page - 1;
            this.loadArticles();
        }
    },
    setPage: function (page, event) {
        event.preventDefault();
        this.state.page = page;
    },
    render: function () {
        return (
            <div className="mh-catalog-list">
                <p>Página {this.state.page} -- {this.state.page > 1 &&
                <button onClick={this.setPage.bind(this, 1)}>Portada</button> }
                    {this.state.page > 1 && <button onClick={this.prevPage}>Más recientes</button> }
                    <button onClick={this.nextPage}>Más antiguas</button>
                </p>
                <CatalogArticleList data={this.state.data}/>
            </div>
        )
    }
});
