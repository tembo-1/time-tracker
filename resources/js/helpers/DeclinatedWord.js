export function getDeclinatedWord (value, root, withNumber = true) {
    const tens = Math.abs(value) % 100;
    const num = value % 10;
    let result = root + 'ов';
    if (tens > 10 && tens < 20) {
        result = root + 'ов';
    } else if (num > 1 && num < 5) {
        result = root + 'а';
    } else if (num == 1) {
        result = root;
    }
    return withNumber ? `${value} ${result}` : result;
}
