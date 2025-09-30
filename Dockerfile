FROM php:8.4

WORKDIR /

# Copy project files
COPY . .

# Expose port
EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080"]
