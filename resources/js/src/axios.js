// axios
import axios from 'axios'
import config from './config.js'


export default axios.create({
  baseURL : window.url,
  headers: {
    'Content-Type': 'application/json',
    'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS'
  }
})
