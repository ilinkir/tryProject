# Image
FROM node:lts

# Set up work directory
WORKDIR /var/www

# Configure host
ENV HOST 0.0.0.0

# Init command
CMD ["sh", "-c", "yarn install && yarn dev -o"]

#FROM node:lts as builder
#
#WORKDIR /app
#
#COPY . .
#
#RUN yarn install \
#  --prefer-offline \
#  --frozen-lockfile \
#  --non-interactive \
#  --production=false
#
#RUN yarn build
#
#RUN rm -rf node_modules && \
#  NODE_ENV=production yarn install \
#  --prefer-offline \
#  --pure-lockfile \
#  --non-interactive \
#  --production=true
#
#FROM node:lts
#
#WORKDIR /app
#
#COPY --from=builder /app  .
#
#ENV HOST 0.0.0.0
#
#CMD [ "yarn", "dev" ]