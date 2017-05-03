var CatalogArticleList = React.createClass({
    render: function () {
        var articles = this.props.data.map(function (article) {
                return (
                    <Article key={article.id} title={article.title} slug={article.slug} image={article.image}></Article>
                );
            }
        );
        return (
            <div className="articles">
                {articles}
            </div>
        );
    }
});
