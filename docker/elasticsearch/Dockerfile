FROM docker.elastic.co/elasticsearch/elasticsearch:7.6.2

COPY ./hunspell /usr/share/elasticsearch/config/hunspell

RUN /usr/share/elasticsearch/bin/elasticsearch-plugin install https://github.com/papahigh/elasticsearch-russian-phonetics/raw/7.6.2/esplugin/plugin-distributions/analysis-russian-phonetic-7.6.2.zip

EXPOSE 9200 9300
