FROM node:22-alpine

# Configure non-root user to use the user & group ids from the docker arguments
ARG UID=1000
ENV UID ${UID}
ARG GID=1000
ENV GID ${GID}

RUN apk --no-cache add shadow && \
    usermod -u ${UID} node && \
    groupmod -g ${GID} node