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
    firstPage: function (event) {
        event.preventDefault();
        this.setState({url: this.state.links['rel=first'], shouldLoad: true});
        this.loadArticles();
    },
    render: function () {
        return (
            <div className="mh-catalog-list">
                <PaginationBar first={this.firstPage} prev={this.prevPage} next={this.nextPage} page={this.state.page}
                               maxPages={this.state.maxPages}/>
                <CatalogArticleList data={this.state.data}/>
            </div>
        )
    }
});

var Button = React.createClass({
    render: function () {
        if (this.props.disabled) {
            return (<button className="button disabled" disabled>{this.props.label}</button>)
        }
        return (<button className="button" onClick={this.props.action}>{this.props.label}</button>);

    }
});

var PaginationBar = React.createClass({
    render: function () {
        return (
            <div className="button-group secondary expanded">
                <span className="primary button">Página {this.props.page} de {this.props.maxPages} </span>
                <Button action={this.props.first} label="Portada" disabled={this.props.page == 1}/>
                <Button action={this.props.prev} label="Más recientes" disabled={this.props.page == 1}/>
                <Button action={this.props.next} label="Más antiguas"
                        disabled={this.props.page == this.props.maxPages}/>
            </div>
        )

    }
});
