import { Select, Space } from 'antd';
import { useState, useEffect } from 'react';
import axios from 'axios';

const Page_select = (props) => {
  const [pagesInSelect, setPagesInSelect] = useState([{ label: 'all pages', value: '' }]);

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/adminPages_and_concurrents', {
      params: {
        page_name: props.page_name,
      },
    })
      .then(response => {
        const data = response.data;
        setPagesInSelect([...pagesInSelect, ...data]);
        props.setselectedpageid("");
        console.log(pagesInSelect);
      })
      .catch(error => {
        console.log(error);
      });
  }, [props.page_name]);

  const handleChange = (value) => {
    props.setselectedpageid(value);
    props.setCurrentPage(1);
  };

  return (
    <Space wrap>
      <Select
        defaultValue='all pages'
        style={{
          width: 200,
        }}
        onChange={handleChange}
        options={pagesInSelect}
      />
    </Space>
  );
};

export default Page_select;
