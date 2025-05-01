function formatTimestamp(timestamp) {
    return (new Date(timestamp)).toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}

export default formatTimestamp
