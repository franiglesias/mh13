function parse_link_header(header) {
    var parts = header.split(',');
    var links = {};
    for (i = 0; i < parts.length; i++) {
        var section = parts[i].split(';');
        var url = section[0].replace(/<([^>]+)>/, '$1').trim();
        var name = section[1].replace(/rel="([^"]+)"/, '$1').trim();
        links[name] = url;
    }
    return links;
}


var CatalogView = React.createClass({
    getInitialState: function () {
        return {data: [], page: 1, links: []};
    },
    loadArticles: function () {
        $.ajax({
            url: this.props.url + '&page=' + this.state.page,
            dataType: 'json',
            success: function (data, status, jqXHR) {
                if (jqXHR.status != "200") {
                    this.state.page = this.state.page - 1;
                    return;
                }
                var links = parse_link_header(jqXHR.getResponseHeader('Link'));
                this.setState({data: data, links: links});

            }.bind(this),
            error: function (xhr, status, err) {
                this.state.page = this.state.page - 1;
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
        } else {
            this.state.page = 1;
        }
        this.loadArticles();
    },
    goPage: function (page, event) {
        event.preventDefault();
        this.state.page = page;
        this.loadArticles();
    },
    render: function () {
        return (
            <div className="mh-catalog-list">
                <p>Página {this.state.page} -- {this.state.page > 1 &&
                <button onClick={this.goPage.bind(this, 1)}>Portada</button> }
                    {this.state.page > 1 && <button onClick={this.prevPage}>Más recientes</button> }
                    <button onClick={this.nextPage}>Más antiguas</button>
                </p>
                <p>
                    <a href={this.state.links['rel=first']}>Primera página</a>
                </p>
                <CatalogArticleList data={this.state.data}/>
            </div>
        )
    }
});
