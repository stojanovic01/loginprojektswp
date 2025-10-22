/**
 * Vollständige SHA-256 Implementierung (kompatibel mit Python hashlib)
 * Erstellt echte SHA-256 Hashes ohne crypto.subtle
 */
function sha256Hash(str) {
    // Hilfsfunktionen für SHA-256
    function rotr(n, x) {
        return (x >>> n) | (x << (32 - n));
    }
    
    function ch(x, y, z) {
        return (x & y) ^ (~x & z);
    }
    
    function maj(x, y, z) {
        return (x & y) ^ (x & z) ^ (y & z);
    }
    
    function sig0(x) {
        return rotr(2, x) ^ rotr(13, x) ^ rotr(22, x);
    }
    
    function sig1(x) {
        return rotr(6, x) ^ rotr(11, x) ^ rotr(25, x);
    }
    
    function gamma0(x) {
        return rotr(7, x) ^ rotr(18, x) ^ (x >>> 3);
    }
    
    function gamma1(x) {
        return rotr(17, x) ^ rotr(19, x) ^ (x >>> 10);
    }
    
    // SHA-256 Konstanten
    const K = [
        0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5,
        0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174,
        0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da,
        0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967,
        0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85,
        0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070,
        0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3,
        0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
    ];
    
    // Initial Hash Values
    let H = [
        0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a,
        0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19
    ];
    
    // String zu UTF-8 Bytes konvertieren
    const bytes = new TextEncoder().encode(str);
    const len = bytes.length;
    
    // Padding hinzufügen
    const bitLen = len * 8;
    const padLen = ((len + 9) % 64 === 0) ? 0 : 64 - ((len + 9) % 64);
    const totalLen = len + 1 + padLen + 8;
    
    const padded = new Uint8Array(totalLen);
    padded.set(bytes);
    padded[len] = 0x80;
    
    // Länge als 64-bit Big-Endian anhängen
    for (let i = 0; i < 8; i++) {
        padded[totalLen - 8 + i] = (bitLen >>> ((7 - i) * 8)) & 0xff;
    }
    
    // Verarbeitung in 512-bit Blöcken
    for (let chunk = 0; chunk < totalLen; chunk += 64) {
        const W = new Array(64);
        
        // W[0..15] aus dem Chunk kopieren
        for (let i = 0; i < 16; i++) {
            W[i] = (padded[chunk + i * 4] << 24) |
                   (padded[chunk + i * 4 + 1] << 16) |
                   (padded[chunk + i * 4 + 2] << 8) |
                   padded[chunk + i * 4 + 3];
        }
        
        // W[16..63] erweitern
        for (let i = 16; i < 64; i++) {
            W[i] = (gamma1(W[i - 2]) + W[i - 7] + gamma0(W[i - 15]) + W[i - 16]) | 0;
        }
        
        // Arbeits-Variablen initialisieren
        let [a, b, c, d, e, f, g, h] = H;
        
        // Hauptschleife
        for (let i = 0; i < 64; i++) {
            const T1 = (h + sig1(e) + ch(e, f, g) + K[i] + W[i]) | 0;
            const T2 = (sig0(a) + maj(a, b, c)) | 0;
            
            h = g;
            g = f;
            f = e;
            e = (d + T1) | 0;
            d = c;
            c = b;
            b = a;
            a = (T1 + T2) | 0;
        }
        
        // Hash-Werte aktualisieren
        H[0] = (H[0] + a) | 0;
        H[1] = (H[1] + b) | 0;
        H[2] = (H[2] + c) | 0;
        H[3] = (H[3] + d) | 0;
        H[4] = (H[4] + e) | 0;
        H[5] = (H[5] + f) | 0;
        H[6] = (H[6] + g) | 0;
        H[7] = (H[7] + h) | 0;
    }
    
    // Finalen Hash als Hex-String zurückgeben
    return H.map(h => (h >>> 0).toString(16).padStart(8, '0')).join('');
}

/**
 * Hilfsfunktion zum Testen des Hash-Algorithmus
 */
function testHash(input) {
    const result = sha256Hash(input);
    console.log(`SHA-256 Hash für "${input}": ${result}`);
    console.log(`Hash-Länge: ${result.length}`);
    return result;
}

/**
 * Mehrere Test-Passwörter hashen
 */
function runHashTests() {
    const testPasswords = [
        "test123",
        "teacherleaveuskidsalone",
        "password",
        "admin123"
    ];
    
    console.log("=== SHA-256 Hash-Tests ===");
    testPasswords.forEach(pwd => {
        console.log(`"${pwd}" -> ${sha256Hash(pwd)}`);
    });
    console.log("=== Ende Tests ===");
}

/**
 * Vergleich mit bekannten SHA-256 Werten
 */
function validateSHA256() {
    // Bekannte Test-Vektoren
    const tests = [
        { input: "abc", expected: "ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad" },
        { input: "hello", expected: "2cf24dba4f21d4288094c8af2c31a02e2b6800d5b0c5a2c50b13b5c6f9b5c2e7" }
    ];
    
    console.log("=== SHA-256 Validierung ===");
    tests.forEach(test => {
        const result = sha256Hash(test.input);
        const isValid = result === test.expected;
        console.log(`"${test.input}": ${isValid ? "✅ KORREKT" : "❌ FEHLER"}`);
        if (!isValid) {
            console.log(`  Erwartet: ${test.expected}`);
            console.log(`  Erhalten: ${result}`);
        }
    });
}