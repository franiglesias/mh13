function parse_link_header(header) {
    var parts = header.split(',');
    var links = {};
    for (i = 0; i < parts.length; i++) {
        var section = parts[i].split(';');
        var url = section[0].replace(/<([^>]+)>/, '$1').trim();
        var name = section[1].replace(/rel=\"([^\"]+)\"/, '$1').trim();
        links[name] = url;
    }
    return links;
}


var CatalogView = React.createClass({
    getInitialState: function () {
        return {data: [], page: 1, shouldLoad: true, links: [], url: this.props.url, maxPages: 100};
    },
    loadArticles: function () {
        if (!this.state.shouldLoad) {
            return;
        }
        $.ajax({
            url: this.state.url,
            dataType: 'json',
            success: function (data, status, jqXHR) {
                if (jqXHR.status != "200") {
                    return;
                }

                this.setState({
                    data: data,
                    links: parse_link_header(jqXHR.getResponseHeader('Link')),
                    page: jqXHR.getResponseHeader('X-Current-Page'),
                    maxPages: jqXHR.getResponseHeader('X-Max-Pages'),
                    shouldLoad: false
                });

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
        this.setState({url: this.state.links['rel=next'], shouldLoad: true});
        this.loadArticles();
    },
    prevPage: function (event) {
        event.preventDefault();
        this.setState({url: this.state.links['rel=prev'], shouldLoad: true});
        this.loadArticles();
    },
    goPage: function (page, event) {
        event.preventDefault();
        this.setState({url: this.state.links['rel=first'], shouldLoad: true});
        this.loadArticles();
    },
    render: function () {
        return (
            <div className="mh-catalog-list">
                <div className="button-group expanded"><span className="secondary button">Página {this.state.page}
                    de {this.state.maxPages} </span>
                    {this.state.page > 1 &&
                    <button className="button" onClick={this.goPage.bind(this, 1)}>Portada</button>                    }
                    {this.state.page == 1 &&
                    <button className="button disabled" onClick={this.goPage.bind(this, 1)} disabled>Portada</button>}
                    {this.state.page > 1 && <button className="button" onClick={this.prevPage}>Más recientes</button>}
                    {this.state.page == 1 &&
                    <button className="button disabled" onClick={this.prevPage} disabled>Más recientes</button>}
                    {this.state.page < this.state.maxPages &&
                    <button className="button" onClick={this.nextPage}>Más antiguas</button> }
                    {this.state.page == this.state.maxPages &&
                    <button className="button disabled" onClick={this.nextPage} disabled>Más antiguas</button>}
                </div>
                <CatalogArticleList data={this.state.data}/>
            </div>
        )
    }
});
