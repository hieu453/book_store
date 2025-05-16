const format = (dateLabel) => {
    const options = {
        month: 'long',
        year: 'numeric',
    }

    return (new Date(dateLabel)).toLocaleDateString('vi-VN', options);
}

export default format;
