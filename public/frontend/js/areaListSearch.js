document.getElementById('keywordInput').addEventListener('blur', function () {
    const inputVal = this.value.trim();
    if (inputVal.length > 0) {
        document.getElementById('coverageSearchForm').submit();
    }
});