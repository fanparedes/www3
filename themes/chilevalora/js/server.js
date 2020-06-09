'use strict'

const path = require('path')
const express = require('express')
const compression = require('compression')

/**
 * Configure server
 */
const app = express()
const hostname = '0.0.0.0'
const port = process.env.PORT || 8079

app.use(compression())
app.use(express.static(path.join(__dirname, '.')))

app.get('*', (req, res) => {
  res.sendFile(path.resolve(__dirname, 'test.html'))
})

app.listen(port, hostname, () => {
  /* eslint-disable-next-line */
  console.log(`Server started: http://${hostname}:${port}`)
})
