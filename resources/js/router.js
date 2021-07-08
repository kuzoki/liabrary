
import home from './pages/home';
import account from './pages/account';
import books from './pages/books';
import axios from 'axios';
// import student from './components/student';


export default ({
    mode: 'history',
    routes: [
        { path: '/', component: home },
        { path: '/account', component: account,
            beforeEnter: (to, from, next) =>{
                axios.get('/api/authenticated').then(()=>{
                    next()
                }).catch(()=>{
                    return next('/')
                })
            }
            

        },
        {
            path: '/account/books',component: books,
            beforeEnter: (to, from, next) =>{
                axios.get('/api/authenticated').then(()=>{
                    next()
                }).catch(()=>{
                    return next('/')
                })
            }
        },
        { path: "*", component: home,
            beforeEnter (to) {
            window.location = '/'
          } }
        // { path: '/:id', component: student, name: "Student" },

    ]
})