const fs = require('fs');

fs.rename('.babelrc', '_.babelrc', (err) => {
    if (err) {
        console.error(err)
        return
    }
});