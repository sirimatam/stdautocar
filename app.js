{
  "name": "Standard Auto Car",
  "description": "This app does one little thing, and does it well.",
  "keywords": [
    "productivity",
    "HTML5",
    "scalpel"
  ],
  "website": "https://standardautocar.herokuapp.com",
  "repository": "https://github.com/sirimatam/stdautocar.git",
  "success_url": "/welcome",
  "scripts": {
    "postdeploy": "bundle exec rake bootstrap"
  },
  "env": {
    "SECRET_TOKEN": {
      "description": "A secret key for verifying the integrity of signed cookies.",
      "generator": "secret"
    },
    "WEB_CONCURRENCY": {
      "description": "The number of processes to run.",
      "value": "5"
    }
  },
  "formation": {
    "web": {
      "quantity": 2,
      "size": "Performance-M"
    }
  },
  "image": "heroku/ruby",
  "addons": [
    "openredis",
    {
      "plan": "mongolab:shared-single-small",
      "as": "MONGO"
    },
    {
      "plan": "heroku-postgresql",
      "options": {
        "version": "9.5"
      }
    }
  ],
  "buildpacks": [
    {
      "url": "https://github.com/stomita/heroku-buildpack-phantomjs"
    }
  ],
  "environments": {
    "test": {
      "scripts": {
        "test": "bundle exec rake test"
      }
    }
  }
}
