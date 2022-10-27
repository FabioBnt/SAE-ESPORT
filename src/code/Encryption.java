package code;

import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.util.Base64;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.KeyGenerator;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.SecretKey;
import javax.crypto.spec.IvParameterSpec;

public class Encryption {
	public static SecretKey generateKey(int n) throws NoSuchAlgorithmException {
        KeyGenerator keyGenerator = KeyGenerator.getInstance("AES");
        keyGenerator.init(n);
        SecretKey key = keyGenerator.generateKey();
        return key;
    }
    
    public static IvParameterSpec generateIv() {
        byte[] iv = new byte[16];
        new SecureRandom().nextBytes(iv);
        return new IvParameterSpec(iv);
    }
    
    public static String encrypt(String algorithm, String input, SecretKey key,
    	    IvParameterSpec iv) throws NoSuchPaddingException, NoSuchAlgorithmException,
    	    InvalidAlgorithmParameterException, InvalidKeyException,
    	    BadPaddingException, IllegalBlockSizeException {
    	    
    	    Cipher cipher = Cipher.getInstance(algorithm);
    	    cipher.init(Cipher.ENCRYPT_MODE, key, iv);
    	    byte[] cipherText = cipher.doFinal(input.getBytes());
    	    return Base64.getEncoder().encodeToString(cipherText);
    	}
}
