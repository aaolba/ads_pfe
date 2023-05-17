import { DownOutlined, UserOutlined } from '@ant-design/icons';
import { Button, Dropdown, Space, Tooltip, message } from 'antd';
import React, { useState } from 'react';

const Status_select = (props) => {

    const [selected,setselected] = useState("Status");

    
    const handleMenuClick = (e) => {
        props.setstatus(e.key);
        props.setCurrentPage(1);
        if(e.key==''){
            setselected("Status");
        }else{
            setselected(e.key);
        }
    };
    const items = [
      {
        label: 'All',
        key: '',

      },
      {
        label: 'Active ',
        key: 'Active',

      },
      {
        label: 'Paused',
        key: 'Paused',

      },

    
    ];
    const menuProps = {
      items,
      onClick: handleMenuClick,
    };

    return (
  <Space wrap>
    <Dropdown menu={menuProps}>
      <Button>
        <Space>
            {selected}
          <DownOutlined />
        </Space>
      </Button>
    </Dropdown>

  </Space>
)};
export default Status_select;