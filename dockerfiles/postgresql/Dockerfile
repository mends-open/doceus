FROM postgres:17

# Install necessary packages and CA certificates
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        build-essential \
        git \
        ca-certificates \
        postgresql-server-dev-17 && \
    rm -rf /var/lib/apt/lists/*

# Clone and install pg_ivm
RUN git clone https://github.com/sraoss/pg_ivm.git /pg_ivm && \
    cd /pg_ivm && \
    make && \
    make install && \
    cd / && \
    rm -rf /pg_ivm
