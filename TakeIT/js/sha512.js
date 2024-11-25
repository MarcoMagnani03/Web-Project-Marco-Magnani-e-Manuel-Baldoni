/*!
 * A JavaScript implementation of the Secure Hash Algorithm, SHA-512, as defined in FIPS PUB 180-2
 * Version 2.2 Copyright (C) Paul Johnston 2000 - 2009
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for details.
 */

function hex_sha512(str) {
    // Preprocessing
    var rotateRight = (x, n) => (x >>> n) | (x << (32 - n));
    var addUnsigned = (x, y) => {
        var lX8 = (x & 0x80000000), lY8 = (y & 0x80000000);
        var lX4 = (x & 0x40000000), lY4 = (y & 0x40000000);
        var result = (x & 0x3FFFFFFF) + (y & 0x3FFFFFFF);
        if (lX4 & lY4) return (result ^ 0x80000000 ^ lX8 ^ lY8);
        if (lX4 | lY4) return (result ^ 0x40000000 ^ lX8 ^ lY8);
        return (result ^ lX8 ^ lY8);
    };

    // Hash constants for SHA-512
    var H = [
        0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a,
        0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19
    ];

    // Convert string to a bit array
    var message = unescape(encodeURIComponent(str));
    var msgLength = message.length;
    var words = [];

    for (var i = 0; i < msgLength; i++) {
        words[(i >> 2)] |= (message.charCodeAt(i) & 0xff) << ((3 - i) % 4) * 8;
    }

    // Padding
    words[(msgLength >> 2)] |= 0x80 << ((3 - msgLength) % 4) * 8;
    words[(((msgLength + 64) >> 9) << 4) + 15] = msgLength * 8;

    // Process the message in successive 512-bit chunks
    for (var chunk = 0; chunk < words.length; chunk += 16) {
        var W = [];
        for (var i = 0; i < 16; i++) W[i] = words[chunk + i];
        for (var i = 16; i < 80; i++) {
            W[i] = addUnsigned(
                rotateRight(W[i - 2], 19) ^ rotateRight(W[i - 2], 61) ^ (W[i - 2] >>> 6),
                W[i - 7]
            );
        }

        // Main hash computation
        var a = H[0], b = H[1], c = H[2], d = H[3];
        var e = H[4], f = H[5], g = H[6], h = H[7];

        for (var i = 0; i < 80; i++) {
            var T1 = addUnsigned(
                h,
                rotateRight(e, 14) ^ rotateRight(e, 18) ^ rotateRight(e, 41),
                ((e & f) ^ (~e & g)),
                0x5a827999,
                W[i]
            );

            var T2 = addUnsigned(
                rotateRight(a, 28) ^ rotateRight(a, 34) ^ rotateRight(a, 39),
                ((a & b) ^ (a & c) ^ (b & c))
            );

            h = g;
            g = f;
            f = e;
            e = addUnsigned(d, T1);
            d = c;
            c = b;
            b = a;
            a = addUnsigned(T1, T2);
        }

        H[0] = addUnsigned(a, H[0]);
        H[1] = addUnsigned(b, H[1]);
        H[2] = addUnsigned(c, H[2]);
        H[3] = addUnsigned(d, H[3]);
        H[4] = addUnsigned(e, H[4]);
        H[5] = addUnsigned(f, H[5]);
        H[6] = addUnsigned(g, H[6]);
        H[7] = addUnsigned(h, H[7]);
    }

    var hash = '';
    for (var i = 0; i < H.length; i++) {
        hash += ('00000000' + H[i].toString(16)).slice(-8);
    }
    return hash;
}
