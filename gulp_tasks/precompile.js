const fs = require('fs');

fs.rename('_.babelrc', '.babelrc', (err) => {
    if (err) {
        console.error(err)
        return
    }
});