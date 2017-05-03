var PublicBlogsList = React.createClass({
    render: function () {
        var blogs = this.props.data.map(function (blog) {
                return (
                    <Blog key={blog.id} title={blog.title} slug={blog.slug} icon={blog.icon}></Blog>
                );
            }
        );
        return (
            <div className="blogsList small-up-1 medium-up-4 large-up-6 row">
                {blogs}
            </div>
        );
    }
});
