import request from '~/util/request';

/**
 * Get CSRF token
 *
 * @return {AxiosPromise}
 */
export function csrf() {
  return request({
    url: '/csrf-cookie',
    method: 'GET'
  });
}

/**
 * Login
 *
 * @param credentials
 * @return {AxiosPromise}
 */
export function login(credentials) {
  return request({
    url: '/auth/login',
    method: 'POST',
    data: credentials
  });
}

/**
 * Logout
 *
 * @return {AxiosPromise}
 */
export function logout() {
  return request({
    url: 'auth/logout',
    method: 'POST'
  });
}
