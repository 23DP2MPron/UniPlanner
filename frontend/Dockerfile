FROM node:22-alpine AS assets
WORKDIR /app/frontend
COPY frontend/package*.json frontend/.npmrc ./
RUN npm ci
COPY frontend/ ./
COPY backend/resources/views/ /app/backend/resources/views/
RUN npm run build

FROM nginx:alpine
COPY --from=assets /app/frontend/dist /usr/share/nginx/html/build
COPY frontend/nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
