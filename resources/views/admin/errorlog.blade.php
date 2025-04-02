<!DOCTYPE html>
<html lang="en">
<head>
    <title>Produkční log</title>
</head>
<style>
    div {
        padding: 0;
        margin: 0;
        color: black;
        font-family: monospace;
        font-size: 13px;
    }
</style>
<body>
<pre>
    {!! $log !!}
</pre>
</body>
<script>
    function getWidth() {
        return Math.max(
            document.body.scrollWidth,
            document.documentElement.scrollWidth,
            document.body.offsetWidth,
            document.documentElement.offsetWidth,
            document.documentElement.clientWidth
        );
    }
    document.getElementById('custom-width').style.width = getWidth() + 'px';
</script>
</html>
