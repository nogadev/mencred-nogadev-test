<script>
document.getElementById('autosize')
    .addEventListener('keyup', function() {
        this.style.overflow = 'hidden';
        this.style.height = this.scrollHeight + 'px';
    }, false);
</script>