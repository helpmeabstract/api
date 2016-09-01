FROM node:argon

# Create a user
RUN useradd --system --user-group --create-home app && mkdir /app && chown app:app /app

# Install some nodemon
RUN npm install -g nodemon

# Install dependency outside of the app volume
COPY package.json /opt/
RUN cd /opt && npm install
ENV NODE_PATH=/opt/node_modules

VOLUME ["/app"]
COPY ./app /app/
USER app
WORKDIR /app
EXPOSE 8080
ENTRYPOINT ["/app/entrypoint.sh"]