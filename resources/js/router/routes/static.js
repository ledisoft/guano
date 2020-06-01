import Wrapper from '~/wrapper/index';

export const staticRoutes = [
  {
    path: '/',
    name: 'Root',
    redirect: 'home',
    component: Wrapper,
    children: [
      {
        path: 'home',
        name: 'Home',
        component: () => import('~/views/home'),
      }
    ]
  }, {
    path: '/login',
    name: 'Login',
    component: () => import('~/views/login'),
  }
];
