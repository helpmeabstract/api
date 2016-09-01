# Help Me Abstract API

## Developer Instructions

### Stuff You'll Need
- A working docker on your local system
- A local node(4) install for running gulp and stuff

### Setting Up Your Dev Environment

```bash
# Install Gulp
> npm install -g gulp

# Install typings
> npm install -g typings
> typings install

# Compile yo' typescript
> gulp compile

# Start the docker container(s)
> docker-compose up

# Automatically compile-on-change
> gulp watch
```