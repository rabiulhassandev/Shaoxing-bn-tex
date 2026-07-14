<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($staticUrls as $url)
    <url>
        <loc>{{ $url }}</loc>
    </url>
@endforeach
@foreach ($fabrics as $fabric)
    <url>
        <loc>{{ route('fabrics.show', $fabric) }}</loc>
        <lastmod>{{ $fabric->updated_at->toAtomString() }}</lastmod>
    </url>
@endforeach
@foreach ($posts as $post)
    <url>
        <loc>{{ route('news.show', $post) }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
    </url>
@endforeach
</urlset>
