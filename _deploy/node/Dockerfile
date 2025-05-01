FROM node:20-alpine

WORKDIR /app

# Can run both frontend and backend builds
CMD sh -c "cd frontend && npm install && npm run build && cd ../backend && npm install"
