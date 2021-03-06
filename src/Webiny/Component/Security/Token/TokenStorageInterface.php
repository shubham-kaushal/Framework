<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\Token;

use Webiny\Component\Security\User\AbstractUser;

/**
 * Token storage interface.
 *
 * @package         Webiny\Component\Security\User\TokenStorage
 */
interface TokenStorageInterface
{

    /**
     * This function provides the token name to the storage.
     *
     * @param string $tokenName Token name.
     */
    public function setTokenName($tokenName);

    /**
     * This function provides the token 'remember me' flag to the storage.
     *
     * @param bool $rememberMe Token rememberme.
     */
    public function setTokenRememberMe($rememberMe);

    /**
     * Save user authentication token.
     *
     * @param AbstractUser $user Instance of AbstractUser class that holds the pre-filled object from user provider.
     *
     * @return bool
     */
    public function saveUserToken(AbstractUser $user);

    /**
     * Check if auth token is present, if true, try to load the right user and return it's username.
     *
     * @return bool|AbstractUser False it user token is not available, otherwise the AbstractUser object is returned.
     */
    public function loadUserFromToken();

    /**
     * Deletes the current auth token.
     *
     * @return bool
     */
    public function deleteUserToken();

    /**
     * Sets the security key that will be used for encryption of token data.
     *
     * @param string $securityKey Must have 16/32/64 chars.
     */
    public function setSecurityKey($securityKey);

    /**
     * Get token string representation
     * @return string
     */
    public function getTokenString();

    /**
     * Save the provided token string into the token storage.
     *
     * @param string $token Token string to save.
     */
    public function setTokenString($token);

    /**
     * Get token TTL in seconds
     *
     * @return int
     */
    public function getTokenTtl();
}